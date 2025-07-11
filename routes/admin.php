<?php

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
