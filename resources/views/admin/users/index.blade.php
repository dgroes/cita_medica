<x-admin-layout title="Usuarios | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Gestión',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
    ],
]">

    {{-- C64: Permisos en acciones --}}
    @can('create_user')
        <x-slot name="action">
        {{-- C24: Creación de un nuevo registo --}}
        <x-wire-button blue href="{{ route('admin.users.create') }}" xs>
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>
    @endcan

    @livewire('admin.datatables.user-table')


</x-admin-layout>
