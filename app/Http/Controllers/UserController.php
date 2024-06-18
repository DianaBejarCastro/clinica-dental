<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Dentist;
use App\Models\Patient;
use App\Models\Center;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Obtener el rol del usuario
        $roleId = DB::table('model_has_roles')->where('model_id', $user->id)->value('role_id');
        $data = [
            'user' => $user,
            'role' => $roleId,
            'relatedData' => null,
        ];

        // Obtener los datos relacionados según el rol
        if ($roleId == 1 || $roleId == 2) {
            $admin = Admin::where('user_id', $user->id)->with('center')->first();
            if ($admin) {
                $data['relatedData'] = [
                    'ci' => $admin->ci,
                    'day_of_birth' => $admin->day_of_birth,
                    'address' => $admin->address,
                    'phone' => $admin->phone,
                    'is_active' => $admin->is_active,
                    'center_name' => $admin->center?->name_branch ?? 'N/A',
                    'created_at' => $admin->created_at,
                ];
            }
        } elseif ($roleId == 3) {
            $dentist = Dentist::where('user_id', $user->id)->with('center')->first();
            if ($dentist) {
                $data['relatedData'] = [
                    'ci' => $dentist->ci,
                    'day_of_birth' => $dentist->day_of_birth,
                    'address' => $dentist->address,
                    'phone' => $dentist->phone,
                    'is_active' => $dentist->is_active,
                    'center_name' => $dentist->center?->name_branch ?? 'N/A',
                    'updated_at' => $dentist->updated_at,
                ];
            }
        } elseif ($roleId == 4) {
            $patient = Patient::where('user_id', $user->id)
                   ->with('center:id,name_branch')
                   ->first();

            if ($patient) {
                $data['relatedData'] = [
                    'identification_number' => $patient->identification_number,
                    'identification_type' => $patient->identification_type,
                    'gender' => $patient->gender,
                    'day_of_birth' => $patient->date_of_birth,
                    'address' => $patient->address,
                    'phone' => $patient->phone,
                    'center_name' => $patient->center?->name_branch ?? 'N/A',
                    'updated_at' => $patient->updated_at,
                ];
            }
        }

        return view('dashboard.profile.index', $data);
    }

    public function indexConfig()
    {
        return view('dashboard.profile.edit');
    }
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Asignar rol de Paciente al usuario
        $user->assignRole('Paciente');

        //return redirect()->route('login')->with('success', 'Usuario registrado exitosamente.');
    }



}
