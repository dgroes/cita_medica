## C64: Permisos en acciones
Además de los permisos de acceso a las distinas secciones del sistema, además deberían estar restringidos ciertos, o más bien "ocultos" ciertos botones y secciones para un determinado rol.
Por ejemplo en el fichero `resources/views/admin/roles/index.blade.php` está el `WireUI Button`:
```php
// resources/views/admin/roles/index.blade.php
<x-slot name="action">
        {{-- C24: Creación de un nuevo registo --}}
        <x-wire-button blue href="{{ route('admin.roles.create') }}" xs>
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>
``` 
Esta parte solo debería tener acceso un rol que tenga permiso de "creacion de un rol", es decir el permiso de `create_role` especificado en `database/seeders/PermissionSeeder.php`. Y los permisos asginados a los distintos roles están en la semilla `database/seeders/RoleSeeder.php`. 
En el caso de la creación de roles solo el admin debería poder ver, según lo especificado en los ficheros nombrados. Blade tiene una directiva llamada `@can`.
> `@can` en Blade es una directiva que nos otorga de forma sencilla la administración de permisos de usuarios directamente en las plantillas Blade. Funciona con el sistema de autorización de Laravel (Policy y Gates) para ocultar o mostrar contenido de los roles o acciones del usuario. (**1: Combrueba lo que hace**: Comprueba si un usuario tiene permiso para realizar una acción, como editar o eliminar una publicación). (**2: Poe qué usarlo:** Mantiene las vistas seguras, limpias y consistentes al manejar los permisos en un solo lugar) (**3:Cómo utilizar:** Envuelve los elementos de la interfaz de usuario con `@can` o `@cannot` el cual restrige el acceso).
### Aplicando las restricciones
Entonces en el fichero `roles/index.php` debería quedar así:
```php
// resources/views/admin/roles/index.blade.php
@can('create_role')
    <x-slot name="action">
    {{-- C24: Creación de un nuevo registo --}}
    <x-wire-button blue href="{{ route('admin.roles.create') }}" xs>
        <i class="fa-solid fa-plus"></i>
        Nuevo
    </x-wire-button>
</x-slot>
@endcan
```
Al igual quel fichero que contiene las `actions` debería tener restricciones:
```php
// resources/views/admin/roles/actions.blade.php
<div class="flex items-center space-x-2">

    {{-- C64: Permisos en acciones --}}
    @can('update_role')
        <x-wire-button href="{{ route('admin.roles.edit', $role) }}" yellow xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
    @endcan

    @can('delete_role')
        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <x-wire-button type="submit" red xs>
                <i class="fa-solid fa-trash"></i>
            </x-wire-button>

        </form>
    @endcan

</div>
```
Con eso bastaría en la sección Roles
### Todas las partes de restricciones:
Las vistas a las cuales se les aplicaron restricciones de acciones serían:
- Usuarios
    - `resources/views/admin/users/index.blade.php`
    - `resources/views/admin/users/actions.blade.php`
- Pacientes
    - `resources/views/admin/patients/actions.blade.php`
- Doctores
    - `resources/views/admin/doctors/actions.blade.php`
- Citas médicas
    - `resources/views/admin/appointments/index.blade.php`
    - `resources/views/admin/appointments/actions.blade.php`
## C65: Discriminación de citas/calendario
Lo lógico en un sistema como este sería en le caso de que sea el usuario `Tormund Giantsbane` que solo me muestre mis citas y que en el calendario solo aparescan las citas asociadas a dicho usuario.
