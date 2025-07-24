<?php

use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

// Redirección a la ruta admintrador
Route::redirect('/', 'admin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Ruta de prueba
Route::get('/test', function () {
    $schedule = \App\Models\Schedule::find(1);
    return $schedule->start_time;
})->name('test');

