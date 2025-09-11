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
}
