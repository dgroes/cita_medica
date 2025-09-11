<x-admin-layout title="Dashboard | Citas médicas">

    @role('Admin')
        {{-- Llamado a: `resources/views/admin/dashboard/admin.blade.php` --}}
        @include('admin.dashboard.admin')
    @endrole

    @role('Doctor')
        @include('admin.dashboard.doctor')
    @endrole()

</x-admin-layout>
