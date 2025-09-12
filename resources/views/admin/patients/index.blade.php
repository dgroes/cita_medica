<x-admin-layout title="Pacientes | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Gestión',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
    ],
]">
     @livewire('admin.datatables.patient-table')
</x-admin-layout>
