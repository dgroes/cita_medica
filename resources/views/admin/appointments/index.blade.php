<x-admin-layout title="Citas | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
    ],
]">

    <x-slot name="action">
        {{-- C24: Creación de un nuevo registo --}}
        <x-wire-button blue href="{{ route('admin.appointments.create') }}" xs>
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.appointment-table', ['namePatient' => request('namePatient') ?? null])


</x-admin-layout>
