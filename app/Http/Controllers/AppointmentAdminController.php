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

class AppointmentAdminController extends Controller
{
   public function index()
    {
        $today = Carbon::today();
    $admin = Auth::user()->admin;

    $adminCenterId = $admin->center_id;

    $appointments = Appointment::where('date', $today)
        ->where('center_id', $adminCenterId)
        ->with(['user', 'dentist.user'])
        ->get();

    $centers = Center::all(); // Obtén todos los centros

    return view('dashboard.admin.appointment.index', compact('appointments', 'today', 'centers'));
    }

    // app/Http/Controllers/AppointmentAdminController.php

    public function getAppointmentsByDate($date)
    {
        $admin = Auth::user()->admin;
        $adminCenterId = $admin->center_id;

        $appointments = Appointment::where('date', $date)
            ->where('center_id', $adminCenterId)
            ->with(['user', 'dentist.user'])
            ->get();

        return response()->json(['appointments' => $appointments]);
    }



    public function indexRegister()
    {
        // Obtener todos los pacientes registrados
        $patients = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('centers', 'patients.center_id', '=', 'centers.id')
            ->select(
                'patients.*',
                'users.name',
                'users.email',
                'users.created_at as user_created_at',
                'patients.updated_at as patient_updated_at',
                'centers.name_branch as center'
            )
            ->get();

        // Obtener los usuarios con el rol de paciente (role_id = 4) que aún no han completado su registro
        $incompletePatients = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('patients', 'users.id', '=', 'patients.user_id')
            ->where('model_has_roles.role_id', 4)
            ->whereNull('patients.id')
            ->select('users.id', 'users.name', 'users.email')
            ->get();

            $centers = DB::table('centers')->get();

            return view('dashboard.admin.appointment.register', [
                'patients' => $patients,
                'incompletePatients' => $incompletePatients,
                'centers' => $centers
            ]);
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




    // AppointmentController.php

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'center_id' => 'required|exists:centers,id',
            'dentist_id' => 'required|exists:dentists,id',
            'start_time' => 'required',
            'user_id' => 'required|exists:users,id', // Validate user_id
        ]);

        $appointment = new Appointment();
        $appointment->date = $request->date;
        $appointment->center_id = $request->center_id;
        $appointment->dentist_id = $request->dentist_id;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = null;
        $appointment->status = 'reservado';
        $appointment->user_id = $request->user_id; // Save user_id
        $appointment->save();

        return response()->json(['success' => 'Cita reservada con éxito']);
    }


    public function edit($id)
{
    $appointment = Appointment::with('user', 'dentist.user', 'center')->findOrFail($id);
    return response()->json($appointment);
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
    return redirect()->route('appointment-admin', ['date' => $updatedDate]);
}




}
