<div class="flex items-center space-x-2">

    {{-- C64: Permisos en acciones --}}
    @can('update_doctor')
        <x-wire-button href="{{ route('admin.doctors.edit', $doctor) }}" yellow xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
        <x-wire-button href="{{ route('admin.doctors.schedules', $doctor) }}" green xs>
            <i class="fa-solid fa-calendar"></i>
        </x-wire-button>
    @endcan


</div>
