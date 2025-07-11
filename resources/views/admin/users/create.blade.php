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
        'name' => 'Nuevo',
    ],
]">

{{-- C32: Creación de nuevo Usuario --}}
<x-wire-card>
    <form action="{{ route('admin.users.store') }}" method="POST">
        {{-- C33: CSRF token --}}
        @csrf
        <div class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <x-wire-input name="name" label="Nombre" icon="user" required placeholder="Ingrese nombre de usuario" :value="old('name')" />
                <x-wire-input name="email" label="Correo electrónico" icon="envelope" suffix="@gmail.com" type="email" required placeholder="Ingrese correo electrónico" :value="old('email')" />
                <x-wire-input name="password" label="Contraseña" icon="lock-closed" type="password" required placeholder="Ingrese contraseña" />
                <x-wire-input name="password_confirmation" label="Confirmar contraseña" icon="lock-closed" type="password" required placeholder="Confirme contraseña" />
            </div>

            <div class="grid sm:grid-cols-2 gap-4">

                <x-wire-input name="address" label="Dirección" icon="home" required placeholder="Ingrese dirección" :value="old('address')" />
                <x-wire-input name="phone" label="Teléfono" icon="phone" required placeholder="Ingrese número de teléfono" :value="old('phone')" />
                <x-wire-input name="dni" label="RUN" icon="identification" description="Run sin giones ni puntos" required placeholder="Ingrese RUN" :value="old('dni')" />

                <x-wire-native-select label="Rol" name="role_name" icon="user-circle" required>

                    <option value="" disabled selected>Selecione un rol</option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">
                            @selected(old('role_id') == $role->id)
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>


            </div>
            <div class="flex justify-end">
                <x-wire-button type="submit" primary>
                    <i class="fa-solid fa-floppy-disk"></i> Guardar
                </x-wire-button>
            </div>

        </div>
    </form>
</x-wire-card>


</x-admin-layout>
