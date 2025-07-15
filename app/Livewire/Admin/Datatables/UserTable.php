<?php

namespace App\Livewire\Admin\Datatables;

use App\Helpers\FormatHelper;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends DataTableComponent
{
    // protected $model = User::class;

    /* C31: Uso de builder() con with('roles') para cargar roles en Livewire Table */
    public function builder(): Builder
    {
        return User::query()
            ->with('roles');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        // $this->setSearchPlaceholder("Buscar");
        // $this->setSearchIcon('heroicon-m-magnifying-glass');

        // $this->setSearch('Laravel');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("Run", "dni")
                ->searchable()
                ->format(fn($value) => FormatHelper::run($value)),
            Column::make("Rol", "roles")
                ->label(function ($row) {
                    return $row->roles->first()?->name ?? 'Sin rol';
                })
                ->sortable(),
            Column::make("Teléfono", "phone")
                ->searchable()
                ->format(fn($value) => FormatHelper::phone($value)),
            Column::make("Dirección", "address")
                ->searchable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Fecha de creación", "created_at")
                ->sortable(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.users.actions', [
                        'user' => $row
                    ]);
                })
        ];
    }
    /* C30: Laravel Livewire Table personalizada */
}
