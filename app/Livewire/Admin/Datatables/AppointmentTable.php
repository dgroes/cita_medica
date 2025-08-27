<?php

namespace App\Livewire\Admin\Datatables;

use App\Helpers\FormatHelper;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTable extends DataTableComponent
{
    // Uso de modelo para evitar relaciones n+1
    public function builder(): Builder
    {
        return Appointment::query()
            ->with('patient.user', 'doctor.user');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Paciente", "patient.user.name")
                ->sortable()
                ->searchable(),
            Column::make("Run", 'patient.user.dni')
                ->searchable()
                ->format(fn($value) => FormatHelper::run($value))
                ->sortable(),
            Column::make("Doctor id", "doctor.user.name")
                ->sortable()
                ->searchable(),
            Column::make("Fecha", "date")
                ->format(function ($value) {
                    return $value->format('Y-m-d');
                })
                ->sortable()
                ->searchable(),
            Column::make("Hora", "start_time")
                ->format(function ($value) {
                    return $value->format('H:i:s');
                })
                ->sortable(),
            Column::make("Hora fin", "end_time")
                ->format(function ($value) {
                    return $value->format('H:i:s');
                })
                ->sortable(),
            Column::make("Acción")
                ->label(function ($row) {
                    return view('admin.appointments.actions', ['appointment' => $row]);
                })

        ];
    }
}
