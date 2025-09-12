<x-admin-layout title="Doctores | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Gestión',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
    ],
]">

@livewire('admin.datatables.doctor-table')

</x-admin-layout>
