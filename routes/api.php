<?php

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* C52: Búsqueda de disponibilidad, selección de horarios y resumen de cita */
Route::get('/patients', function (Request $request) {

    return User::query()
        ->select('id', 'name', 'email')
        ->when(
            $request->search,
            fn($query) => $query
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
        )
        ->when(
            $request->exists('selected'),
            /* fn ($query) => $query->whereIn('id', $request->input('selected', [])), */
            fn($query) => $query->whereHas('patient', function ($query) use ($request) {
                $query->whereIn('id', $request->input('selected', []));
            }),
            fn($query) => $query->limit(10)
        )
        ->whereHas('patient')
        ->with('patient')
        ->orderBy('name')
        ->get()
        ->map(function (User $user) {

            return [
                'id' => $user->patient->id,
                'name' => $user->name,
            ];
        });
})->name('api.patients.index');
