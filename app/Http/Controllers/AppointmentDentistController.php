<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentDentistController extends Controller
{
    public function index()
{
    $dentist = Auth::user()->dentist;

    // Obtener las citas del dentista ordenadas por fecha
    $appointments = Appointment::where('dentist_id', $dentist->id)
        ->orderBy('date', 'asc')
        ->get();
        $centers = Center::all();
    return view('dashboard.dentist.appointment.index', compact('appointments','centers'));
}



public function getAppointmentsByDate($date)
{
    $dentist = Auth::user()->dentist;

    $appointments = Appointment::where('dentist_id', $dentist->id)
        ->where('date', $date)
        ->with(['user', 'dentist.user'])
        ->get();

    return response()->json(['appointments' => $appointments]);
}


    public function getDentistsByCenter($center_id)
    {
        $dentists = Dentist::where('center_id', $center_id)->with('user')->get();
        return response()->json($dentists);
    }

    public function getAvailableTimes(Request $request, $dentist_id)
    {
        $dayOfWeek = $request->query('day_of_week'); // Obtener el día de la semana del query string
        $selectedDate = $request->query('date'); // Obtener la fecha seleccionada del query string

        if (is_null($dayOfWeek)) {
            return response()->json(['error' => 'Day of week is required'], 400);
        }

        // Convertir el número del día de la semana al nombre del día
        $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $dayName = $daysOfWeek[$dayOfWeek];

        $schedules = Schedule::where('dentist_id', $dentist_id)
            ->where('day', $dayName)
            ->where('is_active', true)
            ->get();

        $existingAppointments = Appointment::where('dentist_id', $dentist_id)
            ->where('date', $selectedDate)
            ->where('status', '!=', 'cancelado')
            ->pluck('start_time')
            ->toArray();

        $availableTimes = [];

        foreach ($schedules as $schedule) {
            $start = new \DateTime($schedule->start_time);
            $end = new \DateTime($schedule->end_time);
            $breakStart = $schedule->start_break ? new \DateTime($schedule->start_break) : null;
            $breakEnd = $schedule->end_break ? new \DateTime($schedule->end_break) : null;

            while ($start < $end) {
                if ($breakStart && $start >= $breakStart && $start < $breakEnd) {
                    $start->add(new \DateInterval('PT1H'));
                    continue;
                }
                if (!in_array($start->format('H:i:s'), $existingAppointments)) {
                    $availableTimes[] = $start->format('H:i');
                }
                $start->add(new \DateInterval('PT1H'));
            }
        }

        return response()->json($availableTimes);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'date' => 'required|date',
        'center_id' => 'required|exists:centers,id',
        'dentist_id' => 'required|exists:dentists,id',
        'start_time' => 'required',
    ]);

    $appointment = Appointment::findOrFail($id);
    $appointment->update($request->all());

    session()->flash('success', 'Cita actualizada correctamente.');

    // Obtener la fecha de la cita actualizada
    $updatedDate = $request->input('date');

    // Redirigir a la ruta con la fecha de la cita actualizada
    return redirect()->route('appointment-dentist', ['date' => $updatedDate]);
}
}
