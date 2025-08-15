<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/* C06: Ruta Admin */

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

/* C22: Ruta para los roles (Route::resource): */
Route::resource('roles', RoleController::class);

/* C27: Controller User */
Route::resource('users', UserController::class);

// Rutas de pacientes
Route::resource('patients', PatientController::class)
    ->only(['index', 'edit', 'update']);

//Rutas de doctores
Route::resource('doctors', DoctorController::class)
    ->only(['index', 'edit', 'update']);

//Rute de calendario de Doctores /* C43: Horarios de Doctores */
Route::get('doctors/{doctor}/schedules', [DoctorController::class, 'schedules'])
    ->name('doctors.schedules');

//Ruta para las citas médicas
Route::get('appointments/{appointment}/consultation', [AppointmentController::class, 'consultation'])
    ->name('appointments.consultation');
Route::resource('appointments', AppointmentController::class);
