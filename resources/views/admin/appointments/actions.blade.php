<div class="flex items-center space-x-2">


    @can('read_appointment')
    <x-wire-button href="{{ route('admin.appointments.show', $appointment) }}" xs>
        <i class="fa-solid fa-eye"></i>
    </x-wire-button>
    @endcan

    {{-- C64: Permisos en acciones --}}
    @can('update_appointment')
        <x-wire-button href="{{ route('admin.appointments.edit', $appointment) }}" yellow xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>

        <x-wire-button href="{{ route('admin.appointments.consultation', $appointment) }}" blue xs>
            <i class="fa-solid fa-stethoscope"></i>
        </x-wire-button>
    @endcan


</div>
