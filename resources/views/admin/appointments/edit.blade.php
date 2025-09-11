<x-admin-layout title="Citas | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    {{-- Botón de cancelación de la cita --}}
    <x-slot name="action">
        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">

            @csrf
            @method('DELETE')

            <x-wire-button red type="submit" sm>
                Cancelar cita
            </x-wire-button>

        </form>
    </x-slot>

    <x-wire-card class="mb-4">
        <div class="flex items-ceter justify-between">
            <div>
                <p class="text-lg font-medium">Editando la cita para:
                    <span class="font-bold text-indigo-700">
                        {{ $appointment->patient->user->name }}
                    </span>
                </p>

                <p class="text-sm text-slate-500">
                    Fecha de la cita:
                    <span class="font-semibold text-slate-700">
                        {{ $appointment->date->format('d/m/Y') }} a las
                        {{ $appointment->start_time->format('H:i:s') }}
                    </span>
                </p>
            </div>

            <div>
                <x-wire-badge flat :color="$appointment->status->color()" :label="$appointment->status->label()" />
            </div>

        </div>

    </x-wire-card>


    {{-- Tabla --}}
    @if ($appointment->status->isEditable())
        @livewire('admin.appointment-manager', [
            'appointmentEdit' => $appointment,
        ])
    @else
        <x-wire-card class="mt-4">
            <p class="text-sm text-slate-500">
                Esta cita no se puede editar porque ya ha sido <strong>completada</strong> o <strong>cancelada</strong>
            </p>
        </x-wire-card>
    @endif


</x-admin-layout>
