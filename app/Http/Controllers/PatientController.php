<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Center;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Obtener solo los pacientes registrados
        $patients = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('centers', 'patients.center_id', '=', 'centers.id')
            ->select(
                'patients.id as id',
                'users.name as name',
                'users.email as email',
                'users.created_at as user_created_at',
                'patients.identification_number as identification_number',
                'patients.identification_type as identification_type',
                'patients.gender as gender',
                'patients.date_of_birth as date_of_birth',
                'patients.address as address',
                'patients.phone as phone',
                'patients.user_id as user_id',
                'patients.center_id as center_id',
                'patients.updated_at as patient_updated_at',
                'centers.name_branch as center',

            )
            ->get();

        return view('dashboard.admin.patient.index', compact('patients'));
    }


    public function create()
    {
        // Obtener las sucursales activas
        $centers = Center::where('is_active', true)->get();

        // Pasar las sucursales a la vista
        return view('dashboard.admin.patient.register', compact('centers'));
    }


    public function store(Request $request, CreatesNewUsers $creator)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8', // mínimo 8 caracteres
                'regex:/[a-z]/', // al menos una letra minúscula
                'regex:/[A-Z]/', // al menos una letra mayúscula
                'regex:/[0-9]/', // al menos un número
                'confirmed'
            ],
            'identification_number' => 'required|string|max:20|unique:patients,identification_number',
            'identification_type' => 'required|string',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'center_id' => 'required|integer',
            'emergency_name_1' => 'required|string|max:255',
            'emergency_relationship_1' => 'required|string|max:255',
            'emergency_address_1' => 'nullable|string|max:255',
            'emergency_phone_1' => 'required|string|max:15',
            'emergency_name_2' => 'nullable|string|max:255|required_if:add_second_emergency_contact,on',
            'emergency_relationship_2' => 'nullable|string|max:255|required_if:add_second_emergency_contact,on',
            'emergency_address_2' => 'nullable|string|max:255|required_if:add_second_emergency_contact,on',
            'emergency_phone_2' => 'nullable|string|max:15|required_if:add_second_emergency_contact,on',
        ]);
        // Guardar el segundo contacto de emergencia si el checkbox está marcado
        if ($request->has('add_second_emergency_contact')) {
            $validator->sometimes('emergency_name_2', 'required|string|max:255', function ($input) {
                return $input->add_second_emergency_contact == 'on';
            });

            $validator->sometimes('emergency_relationship_2', 'required|string|max:255', function ($input) {
                return $input->add_second_emergency_contact == 'on';
            });

            $validator->sometimes('emergency_address_2', 'required|string|max:255', function ($input) {
                return $input->add_second_emergency_contact == 'on';
            });

            $validator->sometimes('emergency_phone_2', 'required|string|max:15', function ($input) {
                return $input->add_second_emergency_contact == 'on';
            });
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Crear el usuario
        $user = $creator->create($request->all());
        // Realizar el resto de las operaciones en una transacción para asegurar consistencia de datos
        DB::transaction(function () use ($request, $user) {
            // Crear el paciente
            $patient = Patient::create([
                'identification_number' => $request->identification_number,
                'identification_type' => $request->identification_type,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth, // Cambiado de 'day_of_birth' a 'date_of_birth'
                'address' => $request->address,
                'phone' => $request->phone,
                'image' => null,
                'center_id' => $request->center_id,
                'user_id' => $user->id,
                // Usar el ID del usuario recién creado
            ]);

            // Crear el primer contacto de emergencia
            $emergencyContact1 = EmergencyContact::create([
                'patient_id' => $patient->id,
                'name' => $request->emergency_name_1,
                'relationship' => $request->emergency_relationship_1,
                'address' => $request->emergency_address_1,
                'phone' => $request->emergency_phone_1,
            ]);

            // Guardar el segundo contacto de emergencia si el checkbox está marcado
            if ($request->has('add_second_emergency_contact')) {
                EmergencyContact::create([
                    'patient_id' => $patient->id,
                    'name' => $request->emergency_name_2,
                    'relationship' => $request->emergency_relationship_2,
                    'address' => $request->emergency_address_2,
                    'phone' => $request->emergency_phone_2,
                ]);
            }

            // Asignar el rol al usuario
            $role = Role::find(4);
            if ($role) {
                $user->assignRole($role->name);
            }
        });

        return redirect()->route('patient')->with('success', 'Usuario registrado con éxito.');
    }


    public function setEditId(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:patients,id',
        ]);

        $request->session()->put('patient_edit_id', $request->id);

        return response()->json(['status' => 'success']);
    }

    public function showEditView(Request $request)
    {
        $id = $request->session()->get('patient_edit_id');
        if (!$id) {
            return redirect()->route('patient')->with('error', 'ID de paciente no encontrado en la sesión.');
        }

        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->route('patient')->with('error', 'Paciente no encontrado.');
        }

        $user = $patient->user;
        $centers = Center::all();


        return view('dashboard.admin.patient.edit', compact('patient', 'user', 'centers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $id = $request->session()->get('patient_edit_id');
        if (!$id) {
            return redirect()->route('patient')->with('error', 'ID de paciente no encontrado en la sesión.');
        }

        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->route('patient')->with('error', 'Paciente no encontrado.');
        }

        $user = $patient->user;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'identification_number' => 'required|string|max:20|unique:patients,identification_number,' . $patient->id,
            'identification_type' => 'required|string|max:50',
            'gender' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:admins,phone,' . $patient->id . '|regex:/^[0-9]+$/',
            'center_id' => 'required|exists:centers,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Actualización de los datos del paciente
        $patient->identification_number = $request->input('identification_number');
        $patient->identification_type = $request->input('identification_type');
        $patient->gender = $request->input('gender');
        $patient->date_of_birth = $request->input('date_of_birth');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->center_id = $request->input('center_id');
        $patient->save();

        return redirect()->route('patient')->with('success', 'El paciente se actualizó correctamente.');
    }


    public function changePassword(Request $request)
    {
        $id = $request->session()->get('patient_edit_id');
        if (!$id) {
            return redirect()->route('patient')->with('error', 'ID de paciente no encontrado en la sesión.');
        }

        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->route('patient')->with('error', 'Paciente no encontrado.');
        }

        $user = $patient->user;

        // Validar la nueva contraseña
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8', // mínimo 8 caracteres
                'regex:/[a-z]/', // al menos una letra minúscula
                'regex:/[A-Z]/', // al menos una letra mayúscula
                'regex:/[0-9]/', // al menos un número
                'confirmed'
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si el usuario no tiene contraseña (registrado con Google), permitirle establecer una
        if (!$user->password) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return redirect()->route('patient')->with('success', 'Contraseña establecida exitosamente.');
        }

        // Si el usuario ya tiene una contraseña, permitirle cambiarla
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('patient')->with('success', 'Contraseña actualizada exitosamente.');
    }

    // Manejar la solicitud de establecimiento de contraseña
    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8', // mínimo 8 caracteres
                'regex:/[a-z]/', // al menos una letra minúscula
                'regex:/[A-Z]/', // al menos una letra mayúscula
                'regex:/[0-9]/', // al menos un número
                'confirmed'
            ],
        ]);
        // Obtener el ID del usuario de la sesión
        $id = $request->session()->get('patient_edit_id');
        if (!$id) {
            return redirect()->route('patient')->with('error', 'ID de paciente no encontrado en la sesión.');
        }

        // Obtener el usuario específico mediante su ID
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('patient')->with('error', 'Paciente no encontrado.');
        }
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('patient')->with('success', 'Contraseña establecida correctamente.');
    }
}
