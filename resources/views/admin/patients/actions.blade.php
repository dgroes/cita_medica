<div class="flex items-center space-x-2">
    @can('update_patient')
        <x-wire-button href="{{ route('admin.patients.edit', $patient) }}" yellow xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
    @endcan

</div>
