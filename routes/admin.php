<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/* C06: Ruta Admin */
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

/* C22: Ruta para los roles (Route::resource): */
Route::resource('roles', RoleController::class);
