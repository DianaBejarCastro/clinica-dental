<?php

namespace Database\Seeders;
use App\Models\Center;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Insertar los datos estáticos para la Sucursal Principal
       Center::create([
        'name_branch' => 'Sucursal Principal',
        'city' => 'Cochabamba',
        'address' => 'Av. Humberto Asin Rivero, Cochabamba',
        'is_active' => true,
    ]);

    // Insertar los datos estáticos para la Sucursal Santa Cruz
    Center::create([
        'name_branch' => 'Sucursal Santa Cruz',
        'city' => 'Santa Cruz',
        'address' => 'Av. Las Pampas, Santa Cruz de la Sierra',
        'is_active' => true,
    ]);
}
}
