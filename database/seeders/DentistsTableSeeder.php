<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Dentist;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB; 


class DentistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create the 'Dentist' role if it doesn't exist
        $dentistRole = Role::firstOrCreate(['name' => 'dentist']);

        // List of dentist data
        $dentists = [
         
                [
                    'name' => 'Juan Pérez Martinez',
                    'email' => 'juan.perez@clinicadental.com',
                    'password' => 'Juanpe123',
                    'specialties' => [1, 2],
                    'center_id' => 1,
                    'ci' => '1234567',
                    'day_of_birth' => '1980-01-01',
                    'address' => 'Av. Libertador, Cochabamba, Bolivia',
                    'phone' => '+591 62001234'
                ],
                [
                    'name' => 'María González Sanchez',
                    'email' => 'maria.gonzalez@clinicadental.com',
                    'password' => 'Mariago123',
                    'specialties' => [3, 4],
                    'center_id' => 2,
                    'ci' => '2345678',
                    'day_of_birth' => '1982-02-02',
                    'address' => 'Calle 21 de Mayo, Santa Cruz, Bolivia',
                    'phone' => '+591 72005678'
                ],
                [
                    'name' => 'Carlos López',
                    'email' => 'carlos.lopez@clinicadental.com',
                    'password' => 'Carloslo123',
                    'specialties' => [5, 6],
                    'center_id' => 2,
                    'ci' => '3456789',
                    'day_of_birth' => '1984-03-03',
                    'address' => 'Av. Velarde, Santa Cruz, Bolivia',
                    'phone' => '+591 62666789'
                ],
                [
                    'name' => 'Ana Martínez',
                    'email' => 'ana.martinez@clinicadental.com',
                    'password' => 'Anama123',
                    'specialties' => [7, 8],
                    'center_id' => 2,
                    'ci' => '4567890',
                    'day_of_birth' => '1986-04-04',
                    'address' => 'Calle Sucre, Santa Cruz, Bolivia',
                    'phone' => '+591 62777890'
                ],
                [
                    'name' => 'José Rodríguez',
                    'email' => 'jose.rodriguez@clinicadental.com',
                    'password' => 'Josero123',
                    'specialties' => [1, 3],
                    'center_id' => 1,
                    'ci' => '5678901',
                    'day_of_birth' => '1988-05-05',
                    'address' => 'Calle Bolívar, Cochabamba, Bolivia',
                    'phone' => '+591 62228901'
                ],
                [
                    'name' => 'Laura García',
                    'email' => 'laura.garcia@clinicadental.com',
                    'password' => 'Lauraga123',
                    'specialties' => [2, 4],
                    'center_id' => 1,
                    'ci' => '6789012',
                    'day_of_birth' => '1990-06-06',
                    'address' => 'Av. Antezana, Cochabamba, Bolivia',
                    'phone' => '+591 72349012'
                ],
                [
                    'name' => 'Luis Sánchez',
                    'email' => 'luis.sanchez@clinicadental.com',
                    'password' => 'Luissa123',
                    'specialties' => [5, 7],
                    'center_id' => 1,
                    'ci' => '7890123',
                    'day_of_birth' => '1992-07-07',
                    'address' => 'Av. Heroínas, Cochabamba, Bolivia',
                    'phone' => '+591 72880123'
                ],
                [
                    'name' => 'Elena Gómez',
                    'email' => 'elena.gomez@clinicadental.com',
                    'password' => 'Elenago123',
                    'specialties' => [6, 8],
                    'center_id' => 2,
                    'ci' => '8901234',
                    'day_of_birth' => '1994-08-08',
                    'address' => 'Av. Cañoto, Santa Cruz, Bolivia',
                    'phone' => '+591 72001234'
                ],
                [
                    'name' => 'Javier Díaz',
                    'email' => 'javier.diaz@clinicadental.com',
                    'password' => 'Javierdi123',
                    'specialties' => [1, 5],
                    'center_id' => 1,
                    'ci' => '9012345',
                    'day_of_birth' => '1996-09-09',
                    'address' => 'Calle Lanza, Cochabamba, Bolivia',
                    'phone' => '+591 72552345'
                ],
                [
                    'name' => 'Pedro Flores',
                    'email' => 'pedro.flores@clinicadental.com',
                    'password' => 'Pedrof123',
                    'specialties' => [2, 6],
                    'center_id' => 1,
                    'ci' => '1023456',
                    'day_of_birth' => '1998-10-10',
                    'address' => 'Av. América, Cochabamba, Bolivia',
                    'phone' => '+591 72443456'
                ],
                [
                    'name' => 'Sonia Rivera',
                    'email' => 'sonia.rivera@clinicadental.com',
                    'password' => 'Soniar123',
                    'specialties' => [3, 7],
                    'center_id' => 1,
                    'ci' => '1123456',
                    'day_of_birth' => '1999-11-11',
                    'address' => 'Calle España, Cochabamba, Bolivia',
                    'phone' => '+591 72854567'
                ],
                [
                    'name' => 'Mario Ortiz',
                    'email' => 'mario.ortiz@clinicadental.com',
                    'password' => 'Marioo123',
                    'specialties' => [4, 8],
                    'center_id' => 2,
                    'ci' => '1223456',
                    'day_of_birth' => '2000-12-12',
                    'address' => 'Calle Junín, Santa Cruz, Bolivia',
                    'phone' => '+591 72235678'
                ]
            ];
            


        foreach ($dentists as $dentistData) {
            // Create user
            $user = User::create([
                'name' => $dentistData['name'],
                'email' => $dentistData['email'],
                'password' => Hash::make($dentistData['password']),
            ]);

            // Assign role
            $user->assignRole($dentistRole);

            // Create dentist
            $dentist = Dentist::create([
                'ci' => $dentistData['ci'],
                'day_of_birth' => $dentistData['day_of_birth'],
                'address' => $dentistData['address'],
                'phone' => $dentistData['phone'],
                'center_id' => $dentistData['center_id'],
                'user_id' => $user->id,
            ]);

            // Assign specialties
            $dentist->specialties()->sync($dentistData['specialties']);

            // Create schedules
            $this->createSchedules($dentist->id);
        }
    }
    private function generateTime($minHour, $maxHour)
    {
        $hour = rand($minHour, $maxHour - 1);
        $minute = rand(0, 1) == 1 ? '30:00' : '00:00';
        return sprintf('%02d:%s', $hour, $minute);
    }
    
    private function createSchedules($dentistId)
    {
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    
        foreach ($days as $day) {
            // Check if schedule already exists for this day
            $existingSchedule = DB::table('schedules')
                ->where('day', $day)
                ->where('dentist_id', $dentistId)
                ->exists();
    
            if ($existingSchedule) {
                continue;
            }
    
            // Generate schedule data
            $start_time = $this->generateTime(8, 18);
            $end_time = $this->generateTime(intval(substr($start_time, 0, 2)) + 1, 19);
    
            if (strtotime($start_time) >= strtotime($end_time)) {
                continue;
            }
    
            $hasBreak = rand(0, 1) === 1;
            $start_break = $end_break = null;
    
            if ($hasBreak) {
                // Ensure break time is within 11am to 3pm and lasts a maximum of 2 hours
                $start_break_hour = rand(11, 14); // Break can start between 11am and 2pm (inclusive)
                $start_break_minute = rand(0, 1) == 1 ? '30:00' : '00:00';
                $start_break = sprintf('%02d:%s', $start_break_hour, $start_break_minute);
    
                $end_break_hour = $start_break_hour + 1; // Break lasts exactly 1 hour
                $end_break = sprintf('%02d:%s', $end_break_hour, $start_break_minute);
    
                if (strtotime($start_break) < strtotime($start_time) || strtotime($end_break) > strtotime($end_time) || strtotime($end_break) > strtotime('15:00:00')) {
                    $hasBreak = false;
                    $start_break = $end_break = null;
                }
            }
    
            DB::table('schedules')->insert([
                'day' => $day,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'dentist_id' => $dentistId,
                'start_break' => $start_break,
                'end_break' => $end_break,
                'break' => $hasBreak,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
}
    