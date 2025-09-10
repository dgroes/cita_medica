<div class="flex items-center space-x-2">

    {{-- C64: Permisos en acciones --}}
    @can('update_user')
        <x-wire-button href="{{ route('admin.users.edit', $user) }}" yellow xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
    @endcan

    @can('delete_user')
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <x-wire-button type="submit" red xs>
                <i class="fa-solid fa-trash"></i>
            </x-wire-button>

        </form>
    @endcan
</div>
