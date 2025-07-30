<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ScheduleManager extends Component
{

    public Doctor $doctor;
    public $schedule = [];
    public $days = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        0 => 'Domingo' //En Carbon el domingo es de 0
    ];

    public $apointment_duration = 15;
    public $intervals;

    //Propiedad computada
    #[Computed()]
    public function hourBlocks()
    {
        return CarbonPeriod::create(
            Carbon::createFromTimeString('08:00:00'),
            '1 hour',
            Carbon::createFromTimeString('18:00:00')
        )->excludeEndDate(); ## Excluir de las 18:00 hasta las 19:00
    }

    public function mount()
    {
        $this->intervals = 60 / $this->apointment_duration;
        $this->initialize();
    }

    public function initialize()
    {
        $schedules = $this->doctor->schedules()->get();
        foreach ($this->hourBlocks as $hourBlock) {
            $period = CarbonPeriod::create(
                $hourBlock->copy(),
                $this->apointment_duration . ' minutes',
                $hourBlock->copy()->addHour()
            );

            foreach ($period as $time) {

                foreach ($this->days as $index => $day) {
                    $this->schedule[$index][$time->format('H:i:s')] = $schedules
                        ->contains(function ($schedule) use ($index, $time) {
                            return $schedule->day_of_week == $index && $schedule->start_time->format('H:i:s') == $time->format('H:i:s');
                        });
                }
            }
        }

        // dd($this->schedule);
    }

    public function save()
    {
        // dd($this->schedule);
        $this->doctor->schedules()->delete();

        foreach ($this->schedule as $day_of_week => $intervals) {
            foreach ($intervals as $start_time => $isChecked)

                if ($isChecked) {
                    Schedule::create([
                        'doctor_id' => $this->doctor->id,
                        'day_of_week' => $day_of_week,
                        'start_time' => $start_time,
                        'end_time' => Carbon::createFromTimeString($start_time)
                            ->addMinutes($this->apointment_duration)
                            ->format('H:i:s')
                    ]);
                }
        }
        // Evento dede livewire
        /* C46: Alerta de SweetAlert2 con Livewire */
        $this->dispatch(
            'swal',
            icon: 'success',
            title: 'Horario guardado correctamente',
            text: 'El horario del doctor ha sido actualizado.'
        );
    }

    public function render()
    {
        return view('livewire.admin.schedule-manager');
    }
}
