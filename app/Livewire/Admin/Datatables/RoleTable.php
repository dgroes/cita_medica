<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

/* C23: Tabla de roles (Laravel Livewire Table, "Table DSL") */

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        logger('Rendering columnas...');
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("Fecha Creación", "created_at")
                ->sortable()
                ->format(function ($value) {
                    return $value ? $value->format('d/m/Y H:i') : '';
                }),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.roles.actions', [
                        'role' => $row
                    ]);
                })
        ];
    }
}
