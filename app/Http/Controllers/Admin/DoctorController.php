<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read_doctor');
        return view('admin.doctors.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        Gate::authorize('update_doctor');
        // Traer solo el id y el name de las especialidades
        $specialities = \App\Models\Speciality::select('id', 'name')->get();

        // Traer todas las especialidades
        // $specialities = \App\Models\Speciality::all();
        return view('admin.doctors.edit', compact('doctor', 'specialities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
         Gate::authorize('update_doctor');
        $data = $request->validate([
            'speciality_id' => 'nullable|required|exists:specialities,id',
            'medical_license_number' => 'nullable|required|string|max:255|unique:doctors,medical_license_number,' . $doctor->id,
            'biography' => 'nullable|required|string|max:1000',
            'is_active' => 'boolean'
        ]);
        $doctor->update($data);

        session()->flash('swal', [
            'title' => 'Doctor actualizado',
            'text' => 'El doctor ha sido actualizado correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.doctors.edit', $doctor->id);
    }

    /* C43: Horarios de Doctores */
    public function schedules(Doctor $doctor){
         Gate::authorize('update_doctor');
        return view('admin.doctors.schedules', compact('doctor'));
    }

}
