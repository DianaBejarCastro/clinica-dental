<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AdminController;
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
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
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