<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        // Crear permisos
        $permissions = [
            // Permisos de administradores
            'manage-admins',
            'manage-doctors',
            'manage-appointments',
            'manage-clinic-settings',

            // Permisos de doctores
            'view-clinical-data',
            'manage-clinical-data',

            // Permisos de pacientes
            'create-appointments',
            'view-own-data'
        ];

        // Crear y asignar permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos a roles
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole->givePermissionTo([
            'manage-doctors',
            'manage-appointments',
            'manage-clinic-settings',
        ]);

        $doctorRole->givePermissionTo([
            'view-clinical-data',
            'manage-clinical-data',
            'manage-appointments',
        ]);

        $patientRole->givePermissionTo([
            'create-appointments',
            'view-own-data',
        ]);
    }
}