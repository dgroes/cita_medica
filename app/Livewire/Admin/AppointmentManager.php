<?php

namespace App\Livewire\Admin;

use App\Models\Speciality;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AppointmentManager extends Component
{

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

    public function render()
    {
        // dd("rendering");
        return view('livewire.admin.appointment-manager');
    }
}
