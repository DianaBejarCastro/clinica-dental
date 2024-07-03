<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Center;
use App\Models\Dentist;
use Spatie\Permission\Models\Role;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Specialty;
use App\Models\DentistSpecialty;


class DentistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dentists = DB::table('dentists')
            ->join('users', 'dentists.user_id', '=', 'users.id')
            ->join('centers', 'dentists.center_id', '=', 'centers.id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->leftJoin('dentist_specialty', 'dentists.id', '=', 'dentist_specialty.dentist_id')
            ->leftJoin('specialties', 'dentist_specialty.specialty_id', '=', 'specialties.id')
            ->select(
                'dentists.id as id',
                'dentists.ci as ci',
                'users.name as name',
                'users.email as email',
                'dentists.day_of_birth as birthdate',
                'dentists.address as address',
                'dentists.phone as phone',
                'centers.name_branch as center',
                'roles.name as role',
                'dentists.created_at as dentist_created_at',
                'dentists.updated_at as dentist_updated_at',
                DB::raw('STRING_AGG(specialties.name, \', \') as specialties')
            )
            ->groupBy(
                'dentists.id',
                'dentists.ci',
                'users.name',
                'users.email',
                'dentists.day_of_birth',
                'dentists.address',
                'dentists.phone',
                'centers.name_branch',
                'roles.name',
                'dentists.created_at',
                'dentists.updated_at'
            )
            ->get();
            
        return view('dashboard.admin.dentist.index', compact('dentists'));
    }
    

    public function create()
    {
        $centers = Center::all();
        $specialties = Specialty::all();
        return view('dashboard.admin.dentist.register', compact('centers', 'specialties'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreatesNewUsers $creator)
    {
        $request->validate([
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
            'ci' => 'required|string|max:255|unique:dentists',
            'day_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:dentists,phone',
            'center_id' => 'required|integer',
            'specialties' => 'required|array|min:1', // Al menos una especialidad seleccionada
        ]);


        // Crear el usuario
        $user = $creator->create($request->all());

        // Realizar el resto de las operaciones en una transacción para asegurar consistencia de datos
        DB::transaction(function () use ($request, $user) {
            // Crear el dentista
            $dentist = Dentist::create([
                'ci' => $request->ci,
                'day_of_birth' => $request->day_of_birth,
                'address' => $request->address,
                'phone' => $request->phone,
                'center_id' => $request->center_id,
                'user_id' => $user->id, // Usar el ID del usuario recién creado
                'is_active' => true,
            ]);

            // Asignar el rol al usuario
            // Asignar el rol estático 'doctor' al usuario
            $role = Role::find(3);
            if ($role) {
                $user->assignRole($role->name);
            }

            // Guardar las especialidades seleccionadas
            foreach ($request->specialties as $specialtyId) {
                $dentist->specialties()->attach($specialtyId);
            }
        });

        return redirect()->route('dentist')->with('success', 'El dentista se ha registrado correctamente.');
    }

    public function setEditId(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:dentists,id',
        ]);

        $request->session()->put('dentist_edit_id', $request->id);

        return response()->json(['status' => 'success']);
    }


    public function showEditView(Request $request)
    {
        $id = $request->session()->get('dentist_edit_id');
        if (!$id) {
            return redirect()->route('dentist')->with('error', 'ID de dentista no encontrado en la sesión.');
        }
    
        $dentist = Dentist::with('specialties')->find($id);
        if (!$dentist) {
            return redirect()->route('dentist')->with('error', 'Dentista no encontrado.');
        }
    
        $user = $dentist->user;
        $centers = Center::all();
        $specialties = Specialty::all(); // Obtener todas las especialidades
    
        return view('dashboard.admin.dentist.edit', compact('dentist', 'user', 'centers', 'specialties'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->session()->get('dentist_edit_id');
        if (!$id) {
            return redirect()->route('dentist.index')->with('error', 'ID de dentista no encontrado en la sesión.');
        }

        $dentist = Dentist::find($id);
        if (!$dentist) {
            return redirect()->route('dentist.index')->with('error', 'Dentista no encontrado.');
        }

        $user = $dentist->user;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'ci' => 'required|string|max:20|unique:dentists,ci,' . $dentist->id,
            'day_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:dentists,phone,' . $dentist->id . '|regex:/^[0-9]+$/',
            'center_id' => 'required|exists:centers,id',
            'specialties' => 'array',
        'specialties.*' => 'exists:specialties,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Actualizar datos del dentista
        $dentist->ci = $request->input('ci');
        $dentist->day_of_birth = $request->input('day_of_birth');
        $dentist->address = $request->input('address');
        $dentist->phone = $request->input('phone');
        $dentist->center_id = $request->input('center_id');
        $dentist->save();
        $dentist->specialties()->sync($request->specialties);

        return redirect()->route('dentist')->with('success', 'El Dentista se actualizó correctamente.');
    }



    public function changePassword(Request $request)
    {
        $id = $request->session()->get('dentist_edit_id');
        if (!$id) {
            return redirect()->route('dentist')->with('error', 'ID de dentista no encontrado en la sesión.');
        }

        $dentist = Dentist::find($id);
        if (!$dentist) {
            return redirect()->route('dentist')->with('error', 'Dentista no encontrado.');
        }

        $user = $dentist->user;

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

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('dentist')->with('success', 'Contraseña actualizada exitosamente.');
    }

   public function clearSuccessSession(Request $request)
{
    $request->session()->forget('success');
    return response()->json(['message' => 'Mensaje de éxito eliminado de la sesión']);
}


}
