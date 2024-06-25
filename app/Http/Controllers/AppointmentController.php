<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Center;
use App\Models\Dentist;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())->with(['dentist.user'])->get();
        $centers = Center::all();
        return view('dashboard.patient.appointment.index', compact('appointments', 'centers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonths(2)->format('Y-m-d'),
            'start_time' => 'required',
            'center_id' => 'required|exists:centers,id',
            'dentist_id' => 'required|exists:dentists,id',
        ]);
        $user = auth()->user();
        $existingAppointment = Appointment::where('user_id', $user->id)
            ->where('status', 'reservado')
            ->first();
        if ($existingAppointment) {
            return response()->json(['errors' => ['general' => ['No puede reservar cita dos veces. Podrá cuando la cita que reservó ya sea atendida.']]], 422);
        }
        $appointment = new Appointment();
        $appointment->date = $request->date;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = null;
        $appointment->status = 'reservado';
        $appointment->center_id = $request->center_id;
        $appointment->dentist_id = $request->dentist_id;
        $appointment->user_id = Auth::id();
        $appointment->save();

        return response()->json(['success' => 'Cita reservada con éxito']);
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


    public function cancel(Request $request)
{
    $appointment = Appointment::find($request->appointment_id);
    if ($appointment) {
        $appointment->description = $request->description;
        $appointment->status = 'cancelado';
        $appointment->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
}

}
