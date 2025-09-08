<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

// C62: Restricción de rutas
class DashboardController extends Controller
{
    public function index()
    {
        Gate::authorize('access_dashboard');
        return view('admin.dashboard');
    }
}
