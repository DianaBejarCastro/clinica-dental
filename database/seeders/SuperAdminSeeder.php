<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de que estás utilizando el modelo correcto
use App\Models\Admin; // Modelo para la tabla admins
use Spatie\Permission\Models\Role; // Si estás usando Spatie para roles y permisos
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // 

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
   {
       // Crear el usuario Super Admin
       $superAdmin = User::firstOrCreate(
           ['email' => 'zacproandres@gmail.com'],
           [
               'name' => 'Carla Jordan',
               'password' => Hash::make('carlaJordan123'),
           ]
       );

       // Crear el rol de Super Admin si no existe y asignarlo al usuario
       $role = Role::firstOrCreate(['name' => 'super-admin']);
       if (!$superAdmin->hasRole('super-admin')) {
           $superAdmin->assignRole($role);
       }

       // Crear el registro en la tabla admins si no existe
       Admin::firstOrCreate(
           [
               'ci' => '9376284',
               'user_id' => $superAdmin->id,
           ],
           [
               'day_of_birth' => '1995-06-14',
               'address' => 'Km9 Blanco galindo pasaje portales #786',
               'phone' => '65700513',
               'is_active' => true,
               'center_id' => 1,
           ]
       );
   }
}