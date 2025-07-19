<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    public function edit(Patient $patient)
    {
        $bloodTypes = BloodType::all();

        return view('admin.patients.edit', compact('patient', 'bloodTypes'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //Verificación para saber si "llegan todos los datos".
        // return $request->all();

        $data = $request->validate([
            'date_of_birth' => 'required|date',
            'blood_type_id' => 'required|exists:blood_types,id',
            'allergies' => 'nullable|string|max:255',
            'chronic_conditions' => 'nullable|string|max:255',
            'surgical_history' => 'nullable|string|max:255',
            'family_history' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:255',
            'emergency_contact_name' => 'required|string|max:100',
            'emergency_contact_relationship' => 'required|string|max:50',
            'emergency_contact_phone' => 'required|string|max:11',
        ]);

        $patient->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Paciente actualizado correctamente',
            'text' => 'Los datos del paciente han sido actualizados exitosamente.',
        ]);

        return redirect()->route('admin.patients.edit', $patient);
    }

}
