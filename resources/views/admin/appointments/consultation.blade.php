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
        'name' => 'Consulta',
    ],
]">
    {{-- C56: Consultation(2) --}}
    @livewire('admin.consultation-manager', ['appointment' => $appointment])

</x-admin-layout>
