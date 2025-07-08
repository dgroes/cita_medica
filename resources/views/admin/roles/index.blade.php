<x-admin-layout title="Roles | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],
]">

    <x-slot name="action">
        {{-- C24: Creación de un nuevo registo --}}
        <x-wire-button blue href="{{ route('admin.roles.create') }}" xs>
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

     @livewire('admin.datatables.role-table')
</x-admin-layout>
