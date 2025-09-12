<x-admin-layout title="Citas | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Gestión',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
    ],
]">

    {{-- C64: Permisos en acciones --}}
    @can('create_appointment')
        <x-slot name="action">
            {{-- C24: Creación de un nuevo registo --}}
            <x-wire-button blue href="{{ route('admin.appointments.create') }}" xs>
                <i class="fa-solid fa-plus"></i>
                Nuevo
            </x-wire-button>
        </x-slot>
    @endcan


    @livewire('admin.datatables.appointment-table', ['namePatient' => request('namePatient') ?? null])


</x-admin-layout>
