{{-- C43: Horarios de Doctores --}}
<x-admin-layout title="Horarios | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Horarios',
    ],
]">

 @livewire('admin.schedule-manager', [
    'doctor' => $doctor
    ])

</x-admin-layout>
