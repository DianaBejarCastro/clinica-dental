<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;
class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $specialties = [
            [
                'name' => 'Odontología General',
                'description' => 'Prevención, diagnóstico y tratamiento general de dientes, encías y maxilares, y educación en higiene bucal.'
            ],
            [
                'name' => 'Ortodoncia',
                'description' => 'Corrección de dientes y mandíbulas desalineados mediante brackets, alineadores y retenedores.'
            ],
            [
                'name' => 'Periodoncia',
                'description' => 'Tratamiento de enfermedades de las encías y tejidos de soporte dental, incluyendo gingivitis y periodontitis.'
            ],
            [
                'name' => 'Endodoncia',
                'description' => 'Tratamiento del interior del diente, como conductos radiculares, para eliminar infecciones y aliviar el dolor.'
            ],
            [
                'name' => 'Odontopediatría',
                'description' => 'Atención dental para niños y adolescentes, enfocada en el desarrollo dental y la educación en higiene bucal.'
            ],
            [
                'name' => 'Prostodoncia',
                'description' => 'Restauración y reemplazo de dientes perdidos o dañados con coronas, puentes, dentaduras e implantes.'
            ],
            [
                'name' => 'Cirugía Oral y Maxilofacial',
                'description' => 'Cirugías de boca, mandíbula y cara, incluyendo extracciones de muelas del juicio y tratamiento de fracturas faciales.'
            ],
            [
                'name' => 'Odontología Estética',
                'description' => 'Mejora de la apariencia dental con blanqueamiento, carillas y restauraciones estéticas para una sonrisa atractiva.'
            ]
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }
    }
}
