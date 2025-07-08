<x-admin-layout title="Roles | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">
    <x-wire-card>
        {{-- C24: Creación de un nuevo registo --}}
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <x-wire-input
                label="Nombre" name="name" placeholder="Nombre del rol" value="{{ old('name') }}"

                />
                <div class="flex justify-end mt-4">
                    <x-wire-button type="submit" blue >
                        Guardar
                    </x-wire-button>
                </div>

        </form>
    </x-wire-card>
</x-admin-layout>
