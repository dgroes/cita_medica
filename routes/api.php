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

// C59: Calendario
Route::get('/appointments', function (Request $request) {
    $appointments = Appointment::with(['patient.user', 'doctor.user'])
        ->whereBetWeen('date', [$request->start, $request->end])
        ->get();

    // Configurando el formato de salida para que lo reciba FullCalendar
    return $appointments->map(function (Appointment $appointment) {
        return [
            'id' => $appointment->id,
            'title' => $appointment->patient->user->name,
            'start' => $appointment->start->toIso8601String(),
            'end' => $appointment->end->toIso8601String(),
            'color' => $appointment->status->colorHex(),
            'extendedProps' => [
                // C60: Modal de calendario
                // Envio de información adicional de la cita, pea su uso en el modal
                'dateTime'  => $appointment->start->format('d/m/Y H:i:s'),
                'patient'   => $appointment->patient->user->name,
                'doctor'    => $appointment->doctor->user->name,
                'status'    => $appointment->status->label(),
                'color'     => $appointment->status->color(),
                'url'       => route('admin.appointments.consultation', $appointment),
            ]
        ];
    })->values();
})->name('api.appointments.index');
