<?php

use Illuminate\Support\Facades\Route;

/* C06: Ruta Admin */

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');
