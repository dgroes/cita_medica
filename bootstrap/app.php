<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
         /* C06: Ruta Admin */
        then: function (){
            Route::middleware('web', 'auth')
                ->prefix('admin') //<-- prefijo para no añadir siempre "/admin" en las rutas de routes/admin.php
                ->name('admin.') // <-- nombre para no añadir siempre "admin." en las rutas de routes/admin.php
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
