<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Center;
use App\Models\Dentist;
use App\Models\Specialty;
use App\Models\Schedule;
use Carbon\Carbon;


class ScheduleController extends Controller
{
    public function index(Request $request)
    {
    
        return view('dashboard.admin.schedule.index');
    }
    public function getSchedulesByDay($day)
    {
        $schedules = DB::table('schedules')
            ->join('dentists', 'schedules.dentist_id', '=', 'dentists.id')
            ->join('users', 'dentists.user_id', '=', 'users.id')
            ->where('schedules.day', $day)
            ->where('schedules.is_active', true) // Agregar esta línea para filtrar por is_active true
            ->select('schedules.*', 'users.name as dentist_name')
            ->get();
    
        return response()->json($schedules);
    }
    

    public function tableRegister(Request $request)
    {
        $dentists = DB::table('dentists')
            ->join('users', 'dentists.user_id', '=', 'users.id')
            ->join('centers', 'dentists.center_id', '=', 'centers.id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->leftJoin('dentist_specialty', 'dentists.id', '=', 'dentist_specialty.dentist_id')
            ->leftJoin('specialties', 'dentist_specialty.specialty_id', '=', 'specialties.id')
            ->select(
                'dentists.id as id',
                'dentists.ci as ci',
                'users.name as name',
                'users.email as email',
                'dentists.day_of_birth as birthdate',
                'dentists.address as address',
                'dentists.phone as phone',
                'centers.name_branch as center',
                'roles.name as role',
                'dentists.created_at as dentist_created_at',
                'dentists.updated_at as dentist_updated_at',
                DB::raw('STRING_AGG(specialties.name, \', \') as specialties')
            )
            ->groupBy(
                'dentists.id',
                'dentists.ci',
                'users.name',
                'users.email',
                'dentists.day_of_birth',
                'dentists.address',
                'dentists.phone',
                'centers.name_branch',
                'roles.name',
                'dentists.created_at',
                'dentists.updated_at'
            )
            ->get();
    
        return view('dashboard.admin.schedule.table-register', compact('dentists'));
    }


    public function setEditId(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:dentists,id',
        ]);

        $request->session()->put('dentist_edit_id', $request->id);

        return response()->json(['status' => 'success']);
    }

    public function showEditView(Request $request)
{
    $id = $request->session()->get('dentist_edit_id');
    if (!$id) {
        return redirect()->route('dentist')->with('error', 'ID de dentista no encontrado en la sesión.');
    }

    $dentist = Dentist::with(['center', 'schedules'])->find($id);
    if (!$dentist) {
        return redirect()->route('dentist')->with('error', 'Dentista no encontrado.');
    }

    $user = $dentist->user;
    $centers = Center::all();
    $specialties = Specialty::all();
    $schedules = $dentist->schedules;

    return view('dashboard.admin.schedule.register', compact('dentist', 'user', 'centers', 'specialties', 'schedules'));
}

    
public function store(Request $request)
{
    $validatedData = $request->validate([
        'day' => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'break' => 'nullable|string|in:si,no',
        'start_break' => 'nullable|date_format:H:i|after:start_time|before:end_time',
        'end_break' => 'nullable|date_format:H:i|after:start_break|before:end_time',
    ]);

    try {
        Schedule::create([
            'dentist_id' => $request->dentist_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break' => $request->break === 'si' ? 1 : 0,
            'start_break' => $request->break === 'si' ? $request->start_break : null,
            'end_break' => $request->break === 'si' ? $request->end_break : null,
            
        ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


public function update(Request $request, $id)
{
    // Normalizar los formatos de tiempo antes de la validación
    $request->merge([
        'start_time' => $this->normalizeTime($request->input('start_time')),
        'end_time' => $this->normalizeTime($request->input('end_time')),
        'start_break' => $this->normalizeTime($request->input('start_break')),
        'end_break' => $this->normalizeTime($request->input('end_break')),
    ]);

    $request->validate([
        'start_time' => 'required|date_format:H:i:s',
        'end_time' => 'required|date_format:H:i:s|after:start_time',
        'break' => 'required|in:si,no',
        'start_break' => 'nullable|required_if:break,si|date_format:H:i:s|after_or_equal:11:00:00|before_or_equal:13:00:00',
        'end_break' => 'nullable|required_if:break,si|date_format:H:i:s|after:start_break|before_or_equal:15:00:00',
    ]);

    if ($request->input('break') === 'si') {
        $startBreak = new \DateTime($request->input('start_break'));
        $endBreak = new \DateTime($request->input('end_break'));
        $interval = $startBreak->diff($endBreak);
        $hours = $interval->h + ($interval->i / 60);

        if ($hours > 2) {
            return redirect()->back()->withErrors([
                'end_break' => 'El descanso no puede durar más de 2 horas',
            ])->withInput();
        }
    }

    $schedule = Schedule::findOrFail($id);

    // Normalizar los formatos de tiempo
    $schedule->start_time = $request->input('start_time');
    $schedule->end_time = $request->input('end_time');

    if ($request->input('break') === 'si') {
        $schedule->break = true;
        $schedule->start_break = $request->input('start_break');
        $schedule->end_break = $request->input('end_break');
    } else {
        $schedule->break = false;
        $schedule->start_break = null;
        $schedule->end_break = null;
    }

    // Asignar otros valores que puedan faltar
    $schedule->day = $request->input('day');
    $schedule->dentist_id = $request->input('dentist_id');

    $schedule->save();

    return redirect()->back()->with('success', 'Horario actualizado exitosamente');
}

private function normalizeTime($time)
{
    if ($time !== null && strpos($time, ':') !== false && strlen($time) == 5) {
        // Agregar segundos ":00" si el formato es "H:i"
        return $time . ':00';
    }
    // Si ya tiene el formato "H:i:s" o es null, regresarlo tal cual
    return $time;
}

public function destroy($id)
    {
        $schedule = Schedule::find($id);
        
        if (!$schedule) {
            return response()->json(['error' => 'Horario no encontrado.'], 404);
        }

        $schedule->delete();

        return response()->json(['success' => 'Horario eliminado exitosamente.']);
    }


    public function updateState(Schedule $schedule)
{
    $schedule->update(['is_active' => request('is_active')]);

    return response()->json(['message' => 'Schedule updated successfully']);
}
    
}
