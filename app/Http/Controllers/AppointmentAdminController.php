<?php

namespace App\Http\Controllers;


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

        return view('dashboard.admin.appointment.index', compact('appointments', 'today'));
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
    
        return view('dashboard.admin.appointment.register', [
            'patients' => $patients,
            'incompletePatients' => $incompletePatients
        ]);
    }
    

    
    
}
