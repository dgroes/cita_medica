<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// C59: Calendario
class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }
}
