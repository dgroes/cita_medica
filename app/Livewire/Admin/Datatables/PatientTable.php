<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\FormatHelper;

/* C38: Creación de tabla patient */

class PatientTable extends DataTableComponent
{

    // protected $model = Patient::class;
    public function builder(): Builder
    {
        return Patient::query()
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
            Column::make("Teléfono", "user.phone")
                ->searchable()
                ->format(fn($value) => FormatHelper::phone($value)),
            Column::make("Dirección", "user.address")
                ->searchable(),
            Column::make("Email", "user.email")
                ->sortable(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.patients.actions', [
                        'patient' => $row
                    ]);
                })
        ];
    }
    /* C30: Laravel Livewire Table personalizada */
}
