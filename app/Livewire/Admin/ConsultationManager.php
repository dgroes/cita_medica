<?php

namespace App\Livewire\Admin;

use App\Enums\AppointmentEnum;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use Livewire\Component;

// C56: Consultation(2)
class ConsultationManager extends Component
{
    public Appointment $appointment;
    public Consultation $consultation;
    public Patient $patient;

    public $previousConsultations;

    // Aquí irá el contendido de la consulta
    public $form = [
        'diagnosis' => '',
        'treatment' => '',
        'notes' => '',
        'prescriptions' => [],
    ];

    public function mount(Appointment $appointment)
    {
        $this->consultation = $appointment->consultation;
        $this->patient = $appointment->patient;

        $this->form = [
            'diagnosis' => $this->consultation->diagnosis,
            'treatment' => $this->consultation->treatment,
            'notes' => $this->consultation->notes,
            'prescriptions' => $this->consultation->prescriptions ?? [
                [
                    'medicine' => '', //Medicamento
                    'dosage' => '', //Dosis
                    'frequency' => '', //Frecuencia de uso por cantidad de días
                ]
            ]
        ];
    }

    //Mëtodo para añadir un nuevo medicamento
    public function addPrescription()
    {
        $this->form['prescriptions'][] = [
            'medicine' => '',
            'dosage' => '',
            'frequency' => '',
        ];
    }

    public function removePrescription($index)
    {
        unset($this->form['prescriptions'][$index]);
        $this->form['prescriptions'] = array_values($this->form['prescriptions']);
    }

    public function save()
    {
        // dd($this->form);
        $this->validate([
            'form.diagnosis' => 'required|string|max:255',
            'form.treatment' => 'required|string|max:255',
            'form.notes' => 'nullable|string|max:1000',
            'form.prescriptions' => 'required|array|min:1',
            'form.prescriptions.*.medicine' => 'required|string|max:255',
            'form.prescriptions.*.dosage' => 'required|string|max:255',
            'form.prescriptions.*.frequency' => 'required|string|max:255',
        ]);

        $this->consultation->update($this->form);

        $this->appointment->status = AppointmentEnum::COMPLETED;
        $this->appointment->save();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Consulta guardada correctamente',
            'text' => 'Los detalles de la consulta han sido actualizados.',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
