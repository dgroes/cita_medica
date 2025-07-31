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

    public $specialties = [];

    public function mount()
    {
        $this->specialties = Speciality::all();

        # Sacar hora actual
        $this->search['date'] = now()->hour >= 12
            ? now()->addDay()->format('Y-m-d')
            : now()->format('Y-m-d');
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

        // Buscar Disponibilidad
        $availability = $service->searchAvailability(...$this->search); #date, hour, speciality_id

    }

    public function render()
    {
        // dd("rendering");
        return view('livewire.admin.appointment-manager');
    }
}
