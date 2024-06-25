<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentAdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CompletePatientRegistrationController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Models\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'assign.role.if.not.exists', // Añade este middleware
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('profile');
    });
});

 

Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

//rutas sucursales
Route::resource('centers', CenterController::class);
Route::get('/center', [CenterController::class, 'index'])->name('center');
Route::get('/centers/{id}', [CenterController::class, 'show']);
Route::put('/centers/{id}', [CenterController::class, 'update']);

//rutas especialidades
Route::resource('specialties', SpecialtyController::class);
Route::get('/specialty', [SpecialtyController::class, 'index'])->name('specialty');
Route::get('/specialties/{id}', [CenterController::class, 'show']);
Route::put('/specialties/{id}', [CenterController::class, 'update']);

//rutas administrador
Route::resource('admins', AdminController::class);
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/dashboard/admin/register', [AdminController::class, 'create'])->name('admin.register');
Route::post('/dashboard/admin/register/form', [AdminController::class, 'store'])->name('admin.register.store');
Route::post('/admin/admin/setEditId', [AdminController::class, 'setEditId'])->name('admin.setEditId');
Route::get('/admin/admin/edit/view', [AdminController::class, 'showEditView'])->name('admin.edit.view');
Route::post('/admin/admin/update', [AdminController::class, 'update'])->name('admin.update');
Route::post('/admin/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.changePassword');

//rutas dentistas
Route::resource('dentists', DentistController::class);
Route::get('/dentists', [DentistController::class, 'index'])->name('dentist');
Route::get('/dashboard/dentist/register', [DentistController::class, 'create'])->name('dentist.register');
Route::post('/dashboard/dentist/register/form', [DentistController::class, 'store'])->name('dentist.register.store');
Route::post('/admin/dentist/setEditId', [DentistController::class, 'setEditId'])->name('dentist.setEditId');
Route::get('/admin/dentist/edit/view', [DentistController::class, 'showEditView'])->name('dentist.edit.view');
Route::put('admin/dentist/update', [DentistController::class, 'update'])->name('dentist.update');
Route::post('/admin/dentist/change-password', [DentistController::class, 'changePassword'])->name('dentist.changePassword');

//rutas paciente
Route::resource('patient', PatientController::class);
Route::get('/patients', [PatientController::class, 'index'])->name('patient');
Route::get('/dashboard/patient/register', [PatientController::class, 'create'])->name('patient.register');
Route::post('/dashboard/patient/register/form', [PatientController::class, 'store'])->name('patient.register.store');
Route::post('/admin/patient/setEditId', [PatientController::class, 'setEditId'])->name('patient.setEditId');
Route::get('/admin/patient/edit/view', [PatientController::class, 'showEditView'])->name('patient.edit.view');
Route::put('admin/patient/update', [PatientController::class, 'update'])->name('patient.update');
Route::post('/admin/patient/change-password', [PatientController::class, 'changePassword'])->name('patient.changePassword');

//rutas completar registro de paciente

Route::resource('patientRegister', CompletePatientRegistrationController::class);
Route::get('/patientRegister', [CompletePatientRegistrationController::class, 'index'])->name('complete-patient');
Route::post('/admin/patient/setRegisterId', [CompletePatientRegistrationController::class, 'setRegisterId'])->name('user.setRegisterId');
Route::get('/admin/user-patient/edit/view', [CompletePatientRegistrationController::class, 'showRegisterView'])->name('registerPatient.edit.view');
Route::put('admin/user/update', [CompletePatientRegistrationController::class, 'update'])->name('user.update');

//rutas gestion de perfil 

//Route::resource('profile', UserController::class);
Route::get('/profile', [UserController::class, 'index'])->name('profile');
Route::get('/profile/edit', [UserController::class, 'indexConfig'])->name('profile.edit');


//rutas horarios
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
Route::get('/table/schedule', [ScheduleController::class, 'tableRegister'])->name('schedule.table');
Route::post('/schedule/dentist/setEditId', [ScheduleController::class, 'setEditId'])->name('schedule.setEditId');
Route::get('/admin/schedule/edit/view', [ScheduleController::class, 'showEditView'])->name('schedule.edit.view');
Route::post('/dashboard/schedule/register/form', [ScheduleController::class, 'store'])->name('schedules.store');
Route::put('/schedules/{schedule}',[ScheduleController::class, 'update'])->name('schedule.update');
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
Route::get('/schedules/{day}', [ScheduleController::class, 'getSchedulesByDay']);
Route::put('/update-schedule/{schedule}', [ScheduleController::class, 'updateState']);

//rutas citas medicas
//paciente
Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
Route::get('/appointments/dentists/{center_id}', [AppointmentController::class, 'getDentistsByCenter']);
Route::get('/appointments/available-times/{dentist_id}', [AppointmentController::class, 'getAvailableTimes']);
Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');



//admin
Route::get('/admin/appointment', [AppointmentAdminController::class, 'index'])->name('appointment-admin');
Route::get('/appointments/{date}', [AppointmentAdminController::class, 'getAppointmentsByDate']);
Route::get('/admin/appointment/register', [AppointmentAdminController::class, 'indexRegister'])->name('appointment-admin-register');
