<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Speciality;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AppointmentManager extends Component
{

    public ?Appointment $appointmentEdit = null;

    public $search = [
        'date' => '',
        'hour' => '',
        'speciality_id' => '',
    ];

    public $selectedSchedules = [
        'doctor_id' => '',
        'schedules' => [],
    ];

    public $specialties = [];

    public $availabilities = [];

    public $appointment = [
        'patient_id' => '',
        'doctor_id' => '',
        'date' => '',
        'start_time' => '',
        'end_time' => '',
        'duration' => '',
        'reason' => '',
    ];

    public function mount()
    {
        $this->specialties = Speciality::all();

        # Sacar hora actual
        $this->search['date'] = now()->hour >= 12
            ? now()->addDay()->format('Y-m-d')
            : now()->format('Y-m-d');

        if ($this->appointmentEdit) {
            $this->appointment['patient_id'] = $this->appointmentEdit->patient_id;
        }

        // Verificar si es un paciente.
        if(auth()->user()->hasRole('Paciente')){
            $this->appointment['patient_id'] = auth()->user()->patient->id;
        }
    }

    // Escuchar cambios en selectedSchedules
    public function updated($property, $value)
    {
        if ($property === 'selectedSchedules') {
            $this->fillAppointment($value);
        }
    }

    //Propiedad computada
    #[Computed()]
    public function hourBlocks()
    {
        return CarbonPeriod::create(
            Carbon::createFromTimeString(config('schedule.start_time')),
            '1 hour',
            Carbon::createFromTimeString(config('schedule.end_time'))
        )->excludeEndDate(); ## Excluir de las 18:00 hasta las 19:00
    }

    #[Computed()]
    public function doctorName()
    {
        return $this->appointment['doctor_id']
            ? $this->availabilities[$this->appointment['doctor_id']]['doctor']->user->name
            : 'Por definir';
    }

    /* C50: Buscador de citas médicas (2) */
    public function searchAvailability(AppointmentService $service)
    {

        # 45 mintuos más de la hora actual
        // $minHour = now()->copy()->addMinutes(60)->format('H:i:s');

        $this->validate([
            'search.date' => 'required|date|after_or_equal:today',
            'search.hour' => [
                'required',
                'date_format:H:i:s',
                // Rule::when($this->search['date'] === now()->format('Y-m-d'), [
                //     'after_or_equal:' . $minHour,
                Rule::when($this->search['date'] === now()->format('Y-m-d'), [
                    'after_or_equal:' . now()->format('H:i:s'),
                ])
            ],
        ]);

        $this->appointment['date'] = $this->search['date'];


        // Buscar Disponibilidad
        $this->availabilities = $service->searchAvailability(...$this->search); #date, hour, speciality_id

    }

    /* C52: Búsqueda de disponibilidad, selección de horarios y resumen de cita */
    // Método para llenar los datos de la cita
    public function fillAppointment($selectedSchedules)
    {
        // Ordenar los horarios seleccionados
        $schedules = collect($selectedSchedules['schedules'])
            ->sort()
            ->values();

        // Si hay horarios seleccionados
        if ($schedules->count()) {
            $this->appointment['doctor_id'] = $selectedSchedules['doctor_id'];
            $this->appointment['start_time'] = $schedules->first();
            $this->appointment['end_time'] = Carbon::parse($schedules->last())->addMinutes(config('schedule.appointment_duration'))->format('H:i:s');
            $this->appointment['duration'] = $schedules->count() * config('schedule.appointment_duration');

            return;
        }

        // Si no hay horarios seleccionados
        $this->appointment['doctor_id'] = "";
        $this->appointment['doctor_id'] = "";
        $this->appointment['start_time'] = "";
        $this->appointment['end_time'] = "";
        $this->appointment['duration'] = "";
    }

    public function save()
    {
        $this->validate([
            'appointment.patient_id' => 'required|exists:patients,id',
            'appointment.doctor_id' => 'required|exists:doctors,id',
            'appointment.date' => 'required|date|after_or_equal:today',
            'appointment.start_time' => 'required|date_format:H:i:s',
            'appointment.end_time' => 'required|date_format:H:i:s|after:appointment.start_time',
            'appointment.reason' => 'nullable|string|max:255',
        ]);

        if($this->appointmentEdit)
        {
            $this->appointmentEdit->update($this->appointment);

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Cita actualizada correctamente',
                'text' => 'La cita ha sido actualizada exitosamente.',
            ]);

            $this->searchAvailability(new AppointmentService());

            return;
        }


        // Guardar la cita
        Appointment::create($this->appointment)
            ->consultation()
            ->create([]);


        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita creada exitosamente',
            'text' => 'La cita ha sido registrada correctamente.',
            /*  'timer' => 3000,
            'showConfirmButton' => false, */
        ]);

        return redirect()->route('admin.appointments.index');

        /*  // Resetear los campos
        $this->reset('search', 'selectedSchedules', 'availabilities', 'appointment');

        // Emitir evento para actualizar la lista de citas
        $this->emit('appointmentCreated'); */
    }

    public function render()
    {
        // dd("rendering");
        return view('livewire.admin.appointment-manager');
    }
}
