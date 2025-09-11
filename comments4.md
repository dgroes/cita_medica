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
Para el ejemplo se crearon un par de citas médicas:
```bash
mysql> select doctor_id, date, start_time, end_time, reason from appointments;
+-----------+------------+------------+----------+------------------------------+
| doctor_id | date       | start_time | end_time | reason                       |
+-----------+------------+------------+----------+------------------------------+
|         8 | 2025-09-11 | 09:00:00   | 09:15:00 | Moretón el la mejilla        |
|         7 | 2025-09-12 | 10:30:00   | 10:45:00 | Amputación de mano derecha   |
|         8 | 2025-09-13 | 08:45:00   | 09:00:00 | Dolor intenso en la cabeza   |
|         7 | 2025-09-11 | 11:15:00   | 11:30:00 | Comezón intenso en brazo     |
+-----------+------------+------------+----------+------------------------------+
```
Aquí el `doctor_id` es "Petyr Baelish", teniendo dos citas, pero en calendario actualmente se muestran todas las citas, como en el `select` de arriba, para solucionar eso. Dentro de la tabla de citas debería estar lo siguiente:
```php
// app/Livewire/Admin/Datatables/AppointmentTable.php
public function builder(): Builder
    {
        $query =  Appointment::query()
            ->with('patient.user', 'doctor.user');

        if (auth()->user()->hasRole('Doctor')) {
            $query->whereHas('doctor', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

         if (auth()->user()->hasRole('Paciente')) {
            $query->whereHas('patient', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

        return $query;
    }
```
Aquí se hace una relación con el uso del modelo `Appointment`, para luego aplicar un filtrado si el usuario que está logeado es un paciente o doctor.
De esta forma la visualización de los datos estará separada para cada rol.
## C66: Query Scopes
Para poder restringir las rutas de acceso (URL), se deberá hacer así. Primero se creará un `Scope Global`. En la terminal se creará el `scope` así:
```bash
❯ php artisan make:scope VerifyRole

   INFO  Scope [app/Models/Scopes/VerifyRole.php] created successfully.  
```
Teniendo el fichero:
```php
// app/Models/Scopes/VerifyRole.php
class VerifyRole implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::user()?->hasRole('Doctor')) {
            $builder->whereHas('doctor', function ($builder) {
                $builder->where('user_id', Auth::id());
            });
        }

        if (Auth::user()?->hasRole('Paciente')) {
            $builder->whereHas('patient', function ($builder) {
                $builder->where('user_id', Auth::id());
            });
        }
    }
}
```
- Si el usuario logueado es **Doctor**:
    - Solo verá citas (appointments) que estén relacionadas con su propio registro de doctor.
    (esto asume que el modelo `Appointment` tiene una relación `doctor()` → `belongsTo(Doctor::class)`).
- Si el usuario logueado es **Paciente**:
    - Solo verá sus propias citas, porque el `whereHas('patient')` filtra por user_id igual al `auth()->id()`.
Esto además deberá estar vinculado con el model del `Appointment`:
```php
// app/Models/Appointment.php
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use App\Models\Scopes\VerifyRole;

#[ScopedBy([VerifyRole::class])]
class Appointment extends Model
{...}
```
Entonces en el modelo está `#[ScopedBy([VerifyRole::class])]` Eso indica que **cada vez que se ejecuta una consulta sobre** `Appointment`, se aplicará el scope `VerifyRole`.
A nivel de consulta sería así:
```php
Appointment::all();
```
Y la consulta:
```sql
SELECT * FROM appointments
WHERE EXISTS (
    SELECT * FROM doctors
    WHERE doctors.id = appointments.doctor_id
    AND doctors.user_id = 5
);
```
Donde `5` será el ID del usuario autenticado, lo mismo pasaría en paciente.
Lo genial como se mencionó es que cada vez que se ejecuta una consulta sobre `Appointment` se aplica el scope, entonces funcionará internamente en: 
- `Admin/AppointmentController.php`: Restringiendo las `id` de las `URL` para que se puedan acceder a las consultas del propio doctor. Por ejemplo si la ruta de `Editar/Cita` es: `http://127.0.0.1:8000/admin/appointments/1/edit`. Solo podrá acceder a dicha ruta el Doctor de dicha consulta. 
- `Datatables/AppointmentTable.php`: Aquí solo se visualizarán las filas del doctor o paciente logeado, "no todos los resultados como si pasaría con Admin".
## C67: Permiso por Rol
Como se está utilizando el paquete `spatie/laravel-permission`. En el **ServiceProviders** se agregan varias directivas para su uso en Blade: 
- `@role('admin') ... @endrole`
- `@hasrole('admin') ... @endhasrole`
- `@hasanyrole('admin|editor') ... @endhasanyrole`
- `@hasallroles('admin|editor') ... @endhasallroles`
Ejemplo de uso:
```php
@role('admin')
    <p>Este texto solo lo ve un administrador.</p>
@endrole

@hasrole('editor')
    <p>Solo lo ve un editor.</p>
@endhasrole

@hasanyrole('admin|editor')
    <p>Lo ven administradores y editores.</p>
@endhasanyrole
```
En el caso del proyecto se hace el uso de `@role` en:
```php
// resources/views/admin/appointments/show.blade.php
@role('Doctor')
    <hr class="my-6">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            Notas le médico:
        </h3>
        <p>
            {{ $appointment->consultation->notes ?? 'No hay notas'}}
        </p>
    </div>
@endrole
```
Aquí esta sección solo la podrá visualizar el "Doctor", pero no estaría del todo mal usar `hasanyrole` y que sea accesible por un doctor y el admin, así: `@hasanyrole('Doctor|Admin')`.
