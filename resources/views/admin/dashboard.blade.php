<x-admin-layout title="Dashboard | Citas médicas">

    @role('Admin|Recepcionista')
        {{-- Llamado a: `resources/views/admin/dashboard/admin.blade.php` --}}
        @include('admin.dashboard.admin')
    @endrole

    @role('Doctor')
        @include('admin.dashboard.doctor')
    @endrole()

    @role('Paciente')
        @include('admin.dashboard.patient')
    @endrole()

</x-admin-layout>
