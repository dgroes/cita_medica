{{-- C43: Horarios de Doctores --}}
<x-admin-layout title="Horarios | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Gestión',
        'href' => route('admin.dashboard'),
    ],
     [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index'),
    ],
    [
        'name' => 'Horarios',
    ],
]">

 @livewire('admin.schedule-manager', [
    'doctor' => $doctor
    ])

</x-admin-layout>
