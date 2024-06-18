<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Center;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = DB::table('admins')
            ->join('users', 'admins.user_id', '=', 'users.id')
            ->join('centers', 'admins.center_id', '=', 'centers.id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select(
                'admins.id as id',
                'admins.ci as ci',
                'users.name as name',
                'users.email as email',
                'admins.day_of_birth as birthdate',
                'admins.address as address', // Nuevo campo address
                'admins.phone as phone', // Nuevo campo phone
                'centers.name_branch as center',
                'roles.name as role',
                'admins.created_at as admin_created_at',
                'admins.updated_at as admin_updated_at'
            )
            ->get();
    
        return view('dashboard.admin.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener las sucursales activas
        $centers = Center::where('is_active', true)->get();

        // Pasar las sucursales a la vista
        return view('dashboard.admin.admin.register', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreatesNewUsers $creator)
{
    // Validar los datos del formulario
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
        'ci' => 'required|string|max:255|unique:admins',
        'day_of_birth' => 'required|date',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:admins,phone',
        'center_id' => 'required|integer|',
        'role_id' => 'required|integer|in:1,2',
    ]);

    // Crear el usuario
    $user = $creator->create($request->all());

    // Realizar el resto de las operaciones en una transacción para asegurar consistencia de datos
    DB::transaction(function () use ($request, $user) {
        // Crear el admin
        $admin = Admin::create([
            'ci' => $request->ci,
            'day_of_birth' => $request->day_of_birth,
            'address' => $request->address,
            'phone' => $request->phone,
            'center_id' => $request->center_id,
            'user_id' => $user->id, // Usar el ID del usuario recién creado
            'is_active' => true,
        ]);

        // Asignar el rol al usuario
        $role = Role::find($request->role_id);
        if ($role) {
            $user->assignRole($role->name);
        }
    });

    return redirect()->route('admin')->with('success', 'Usuario registrado con éxito.');
}



    /**
     * Show the form for editing the specified resource.
     */
    public function setEditId(Request $request)
    {
        $request->session()->put('admin_edit_id', $request->input('id'));
        return response()->json(['success' => true]);
    }
    
    public function showEditView(Request $request)
    {
    $id = $request->session()->get('admin_edit_id');
    if (!$id) {
        // Maneja el caso donde no se encuentra el ID en la sesión
        return redirect()->route('admin')->with('error', 'ID de administrador no encontrado en la sesión.');
    }

    $admin = Admin::find($id);
    if (!$admin) {
        // Maneja el caso donde no se encuentra el administrador
        return redirect()->route('admin')->with('error', 'Administrador no encontrado.');
    }

    $user = $admin->user; // Asumiendo que tienes una relación definida en el modelo Admin
    $centers = Center::all(); // Obtener todos los centros

    return view('dashboard.admin.admin.edit', compact('admin', 'user', 'centers'));
}
    



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    $id = $request->session()->get('admin_edit_id');
    if (!$id) {
        return redirect()->route('admin.index')->with('error', 'ID de administrador no encontrado en la sesión.');
    }

    $admin = Admin::find($id);
    if (!$admin) {
        return redirect()->route('admin.index')->with('error', 'Administrador no encontrado.');
    }

    $user = $admin->user;

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'ci' => 'required|string|max:20|unique:admins,ci,' . $admin->id,
        'day_of_birth' => 'required|date',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:admins,phone,' . $admin->id . '|regex:/^[0-9]+$/',
        'center_id' => 'required|exists:centers,id',
        'role_id' => 'required|in:1,2',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Actualizar datos del usuario
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->save();

    // Actualizar datos del administrador
    $admin->ci = $request->input('ci');
    $admin->day_of_birth = $request->input('day_of_birth');
    $admin->address = $request->input('address');
    $admin->phone = $request->input('phone');
    $admin->center_id = $request->input('center_id');
    $admin->save();

    // Actualizar rol del usuario
    $user->roles()->sync([$request->input('role_id')]);

    return redirect()->route('admin')->with('success', 'El administrador se actualizó correctamente.');
}


public function changePassword(Request $request)
{
    $id = $request->session()->get('admin_edit_id');
    if (!$id) {
        return redirect()->route('admin')->with('error', 'ID de administrador no encontrado en la sesión.');
    }

    $admin = Admin::find($id);
    if (!$admin) {
        return redirect()->route('admin')->with('error', 'Administrador no encontrado.');
    }

    $user = $admin->user;

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

    return redirect()->route('admin')->with('success', 'Contraseña actualizada exitosamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
