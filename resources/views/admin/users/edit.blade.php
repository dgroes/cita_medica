<x-admin-layout title="Usuarios | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Editar Usuario',
    ],
]">


<x-wire-card>
    {{-- C35: Edición de usuario (syncRoles) --}}
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        {{-- C33: CSRF token --}}
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <x-wire-input name="name" label="Nombre" icon="user" required placeholder="Ingrese nombre de usuario" :value="old('name', $user->name)" />
                <x-wire-input name="email" label="Correo electrónico" icon="envelope" suffix="@gmail.com" type="email" required placeholder="Ingrese correo electrónico" :value="old('email', $user->email)" />
                <x-wire-input name="password" label="Contraseña" icon="lock-closed" type="password" placeholder="Ingrese contraseña" />
                <x-wire-input name="password_confirmation" label="Confirmar contraseña" icon="lock-closed" type="password" placeholder="Confirme contraseña" />
            </div>

            <div class="grid sm:grid-cols-2 gap-4">

                <x-wire-input name="address" label="Dirección" icon="home" required placeholder="Ingrese dirección" :value="old('address', $user->address)" />
                <x-wire-input name="phone" label="Teléfono" icon="phone" required placeholder="Ingrese número de teléfono" :value="old('phone', $user->phone)" />
                <x-wire-input name="dni" label="RUN" icon="identification" description="Run sin giones ni puntos" required placeholder="Ingrese RUN" :value="old('dni', $user->dni)" />

                <x-wire-native-select label="Rol" name="role_name" icon="user-circle" required>

                    @php
                        $selectedRole = old('role_name') ?? $user->getRoleNames()->first() ?? '';
                    @endphp

                    <option value="" disabled selected>Selecione un rol</option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @selected($selectedRole === $role->name)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>


            </div>
            <div class="flex justify-end">
                <x-wire-button type="submit" primary>
                    <i class="fa-solid fa-floppy-disk"></i> Actualizar
                </x-wire-button>
            </div>

        </div>
    </form>
</x-wire-card>



</x-admin-layout>
