<?php

namespace App\Livewire\Admin\Datatables;

use App\Helpers\FormatHelper;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class DoctorTable extends DataTableComponent
{
    // protected $model = Doctor::class;
    public function builder(): Builder
    {
        return Doctor::query()
            ->with('user');
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
            Column::make("Nombre", "user.name")
                ->sortable(),
            Column::make("Run", "user.dni")
                ->searchable()
                ->format(fn($value) => FormatHelper::run($value))
                ->sortable(),
            Column::make("Especialidad", "speciality.name")
                ->format(fn($value) => $value ?? 'Sin especialidad')
                ->searchable()
                ->sortable(),
            Column::make("Número de licencia médica", "medical_license_number")
                ->format(fn($value) => $value ?? 'Sin licencia')
                ->searchable(),
            /* Column::make("Biografía", "biography")
                ->format(fn($value) => $value ? Str::limit($value, 20) : 'Sin biografía'), */
            Column::make("Teléfono", "user.phone")
                ->searchable()
                ->format(fn($value) => FormatHelper::phone($value)),
            Column::make("Email", "user.email")
                ->sortable(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.doctors.actions', [
                        'doctor' => $row
                    ]);
                })
        ];
    }
}
