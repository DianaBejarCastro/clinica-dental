<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Center;
use App\Models\EmergencyContact;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CompletePatientRegistrationController extends Controller
{
    
    public function index(Request $request)
    {
        // Obtener solo los pacientes registrados
        $users = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftJoin('patients', 'users.id', '=', 'patients.user_id')
        ->where('model_has_roles.role_id', 4)
        ->whereNull('patients.user_id')
        ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.updated_at')
        ->get();

        return view('dashboard.admin.patient.new.index', compact('users'));
    }


    public function setRegisterId(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $request->session()->put('user_edit_id', $request->id);

        return response()->json(['status' => 'success']);
    }


    public function showRegisterView(Request $request)
    {
        $id = $request->session()->get('user_edit_id');
        if (!$id) {
            return redirect()->route('complete-patient')->with('error', 'ID de paciente no encontrado en la sesión.');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('complete-patient')->with('error', 'Paciente no encontrado.');
        }

        $centers = Center::all();


        return view('dashboard.admin.patient.new.register', compact('user', 'centers'));
    }


    public function update(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
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

        // Obtener el ID del usuario de la sesión
        $id = $request->session()->get('user_edit_id');
        if (!$id) {
            return redirect()->route('complete-patient')->with('error', 'ID de paciente no encontrado en la sesión.');
        }

        // Obtener el usuario específico mediante su ID
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('complete-patient')->with('error', 'Paciente no encontrado.');
        }

        // Actualizar el nombre del usuario en la tabla 'users'
        $user->name = $request->input('name');
        $user->save();

        // Actualizar o crear el registro en la tabla 'patients'
        $patient = Patient::updateOrCreate(
            ['user_id' => $user->id], // Buscar por user_id
            [
                'identification_number' => $request->identification_number,
                'identification_type' => $request->identification_type,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'phone' => $request->phone,
                'center_id' => $request->center_id,
            ]
        );
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

        return redirect()->route('patient')->with('success', 'Perfil actualizado correctamente.');
    }


}
