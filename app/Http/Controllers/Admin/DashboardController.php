<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentEnum;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

// C62: Restricción de rutas
class DashboardController extends Controller
{
    public function index()
    {
        Gate::authorize('access_dashboard');

        $data = [];

        // Acceso de los datos para Admin y Recepcionista:
        if (auth()->user()->hasRole('Admin')) {
            // Total de pacientes
            $data['total_patients'] = Patient::count();

            // Total de doctores
            $data['total_doctors'] = Doctor::count();

            // Cantidad de citas de hoy
            $data['appointments_today'] = Appointment::whereDate('created_at', now())
                ->where('status', '!=', AppointmentEnum::SCHEDULED)
                ->count();

            // Ultimos usuarios registrados
            $data['recent_users'] = User::latest()
                ->take(5)
                ->get();

            return view('admin.dashboard', compact('data'));
        }

        // Acceso de los datos para Doctores:
        if (auth()->user()->hasRole('Doctor')) {

            // Citas totales de hoy
            $data['appointments_today_count'] = Appointment::whereDate('created_at', now())
                ->where('status', AppointmentEnum::SCHEDULED)
                ->whereHas('doctor', function ($query) {
                    $query->where('user_id', auth()->id());
                })->count();

            // Citas de la semana
            $data['appointments_week_count'] = Appointment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->where('status', AppointmentEnum::SCHEDULED)
                ->whereHas('doctor', function ($query) {
                    $query->where('user_id', auth()->id());
                })->count();

            // Proxima cita
            $data['next_appointment'] = Appointment::whereHas('doctor', function ($query) {
                $query->where('user_id', auth()->id());
            })
                ->where('status', AppointmentEnum::SCHEDULED)
                ->whereDate('date', '>=', now())
                ->whereTime('end_time', '>=', now()->toTimeString())
                ->orderBy('start_time')
                ->first();

            $data['appointments_today'] = Appointment::whereHas('doctor', function ($query) {
                $query->where('user_id', auth()->id());
            })
                ->where('status', AppointmentEnum::SCHEDULED)
                ->whereDate('date', '>=', now())
                ->whereTime('end_time', '>=', now()->toTimeString())
                ->orderBy('start_time')
                ->get();
        }

        return view('admin.dashboard', compact('data'));
    }
}
