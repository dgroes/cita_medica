<?php

namespace App\Livewire\Admin\Datatables;

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
                ->format(function ($value) {
                    return $this->formatRun($value);
                }),
            Column::make("Rol", "roles")
                ->label(function ($row) {
                    return $row->roles->first()?->name ?? 'Sin rol';
                })
                ->sortable(),
            Column::make("Teléfono", "phone")
                ->searchable()
                ->format(function ($value) {
                    return $this->formatPhone($value);
                }),
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
    protected function formatRun($run)
    {
        // Limpiar todo menos números y la letra k (en minúscula)
        $run = preg_replace('/[^0-9kK]/', '', $run);

        // Separar dígito verificador
        $dv = strtoupper(substr($run, -1));
        $num = substr($run, 0, -1);

        // Formatear con puntos
        $formatted = number_format($num, 0, '', '.');

        return $formatted . '-' . $dv;
    }

    protected function formatPhone($phone)
    {
        // Asgurarse que solo debe tener solo dígitos
        $digits = preg_replace('/\D/', '', $phone);

        // Verificar longitud esperada (ej: 11 dígitos: 56 9 XXXX XXXX)
        if (strlen($digits) === 11 && substr($digits, 0, 3) === '569') {
            $country = substr($digits, 0, 2); // 56
            $carrier = substr($digits, 2, 1); // 9
            $part1 = substr($digits, 3, 4);   // XXXX
            $part2 = substr($digits, 7);      // XXXX
            return "{$country} {$carrier} {$part1} {$part2}";
        }

        // Si no cumple el formato esperado, devuelve sin cambios
        return $phone;
    }
}
