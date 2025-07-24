## C41: Contenedor principal con AlpineJS
Dentro del fichero `resources/views/admin/patients/edit.blade.php` se hace uso de **AlpineJS**. [Alpine](https://alpinejs.dev/) es un framework JavaScript ligero para interactividad en el frontend Funciona similar a Vue pero dentro de HTML, lo que hace ideal para proyectos como Laravel con Blade.
Siguiendo con el fichero `/patients/edit.blade.php`:
### Declaración de estado (`x-data`):
```php
<div x-data="{ tab: 'datos-personales' }">
```
Esto **inicializa AlpineJS** con un objeto que contiene un estado llamado `tab`. Aquí se define que la pestaña activa por defecto será `"datos-personales"`. Es decir, cuando se carge la vista, estará visible la sección de datos personales.
### Cambio de pestaña (`x-on:click`)
```php
<a href="#" x-on:click="tab = 'antecedentes'">
```
Cada `<a>` que representa una pestaña tiene un **evento** `click` que actualiza el estado `tab`. Ejemplo:
```ts
tab = 'antecedentes'
```
Cuando se hace clic en esa pestaña, se cambia el valor de `tab`, y eso afectará lo que se muestra.
### Aplicar clases condicionales (`:class`)
```html
:class="{ 'clase-activa': tab === 'datos-personales', 'clase-inactiva': tab !== 'datos-personales' }"
```
Esto aplica clases CSS **dinámicamente** según cuál tab esté activa.
### Mostrar contenido dinámicamente (`x-show`)
```php
<div x-show="tab === 'datos-personales'">
```
Este `div` solo será visible cuando `tab` sea igual a `datos-personales`.
Así funciona con cada sección:
- `x-show="tab === 'datos-personales'"`
- `x-show="tab === 'antecedentes'"`
- `x-show="tab === 'informacion-general'"`
- `x-show="tab === 'contacto-emergencia'"`
### Efecto esperado
Cuando el usuario hace clic es una pestaña:
- Se actualiza el valor de `tab`.
- Se ocultan todas las secciones excepto la que coincide con `tab`.
- Se aplican estilos que destacan la pestaña activa.
### Código completo
En caso de que se actualice el fichero, aquí está el código completo y el commit de referencia:
```html
<x-wire-card>
            {{-- C41: Contenedor principal con AlpineJS --}}
            <div class="" x-data ="{
                tab: 'datos-personales' }">

                {{-- Pestañas de navegación --}}
                <div class="border-b border-gray-200 dark:border-gray-700">

                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">

                        {{-- Pestaña: Datos personales --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'datos-personales'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'datos-personales',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'datos-personales'
                                }">
                                <i class="fa solid fa-user me-2"></i>
                                Datos personales
                            </a>
                        </li>

                        {{-- Pestaña: Antecedentes --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'antecedentes'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'antecedentes',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'antecedentes'
                                }"
                                aria-current="page">
                                <i class="fa-solid fa-file-lines me-2"></i>
                                Antecedentes
                            </a>
                        </li>

                        {{-- Pestaña: Información General --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'informacion-general'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'informacion-general',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'informacion-general'
                                }">
                                <i class="fa-solid fa-info me-2"></i>
                                Información General
                            </a>
                        </li>

                        {{-- Pestaña: Contacto de emergencia --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'contacto-emergencia'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'contacto-emergencia',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'contacto-emergencia'
                                }">
                                <i class="fa-solid fa-phone me-2"></i>
                                Contacto de emergencia
                            </a>
                        </li>
                    </ul>

                </div>

                {{-- Tab content (Contenedor de contenido de las pestañas) --}}
                {{-- C40: Helper dentro de una View de Blade --}}
                @php
                    $formattedPhone = \App\Helpers\FormatHelper::phone($patient->user->phone);
                @endphp

                {{-- Contenido de cada tab --}}
                <div class="px-4 mt-4">

                    {{-- Datos Pesonales --}}
                    <div x-show="tab === 'datos-personales'">

                        {{-- Componente de alerte(WireUI) --}}
                        <x-wire-alert info title="Edicion de usuario" class="mb-4">

                            <p>
                                Para editar esta información, dirigete al
                                <a href="{{ route('admin.users.edit', $patient->user) }}"
                                    class="text-blue-500 hover:underline" target="_blank">
                                    perfil del usuario
                                </a>
                                asociado a este paciente.
                            </p>

                        </x-wire-alert>

                        {{-- Contenido de datos personales del paciente: --}}
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-500 font-semibold text-sm">
                                    Teléfono:
                                </span>
                                <span class="text-gray-900 text-sm ml-1">
                                    {{ $patient->user->phone ? $formattedPhone : 'No disponible' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold text-sm">
                                    Email:
                                </span>
                                <span class="text-gray-900 text-sm ml-1">
                                    {{ $patient->user->email ?? 'No disponible' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold text-sm">
                                    Dirección:
                                </span>
                                <span class="text-gray-900 text-sm ml-1">
                                    {{ $patient->user->address ?? 'No disponible' }}
                                </span>
                            </div>
                        </div>

                    </div>

                    {{-- Antecedentes --}}
                    <div x-show="tab === 'antecedentes'">

                        <div class="grid lg:grid-cols-2 gap-2">

                            {{-- Campo Alergias --}}
                            <div>
                                <x-wire-textarea label="Alergias conocidas" name="allergies">
                                    {{ old('allergies', $patient->allergies) }}
                                </x-wire-textarea>
                            </div>

                            {{-- Enfermedade crónicas --}}
                            <div>
                                <x-wire-textarea label="Enfermedades crónicas" name="chronic_conditions">
                                    {{ old('chronic_conditions', $patient->chronic_conditions) }}
                                </x-wire-textarea>
                            </div>

                            {{-- Historial Médico --}}
                            <div>
                                <x-wire-textarea label="Antecedentes quirúrgicos" name="surgical_history">
                                    {{ old('surgical_history', $patient->surgical_history) }}
                                </x-wire-textarea>
                            </div>

                            {{-- Historial Familiar --}}
                            <div>
                                <x-wire-textarea label="Antecedentes familiares" name="family_history">
                                    {{ old('family_history', $patient->family_history) }}
                                </x-wire-textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Información General --}}
                    <div x-show="tab === 'informacion-general'">

                        {{-- Edad del paciente --}}
                        <x-wire-datetime-picker
                           label="Fecha de nacimiento"
                            name="date_of_birth"
                            without-time="true"
                            clearable="false"
                            max="{{ now()->format('Y-m-d') }}"
                            class="mb-4"
                            :value="old('date_of_birth', $patient->date_of_birth)"
                        />

                        {{-- Selección de tipo de sangre --}}
                        <x-wire-native-select label="Tipo de sangre" class="mb-4" name="blood_type_id">

                            <option value="">Seleccione un tipo de sangre</option>

                            @foreach ($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}" @selected($bloodType->id === $patient->blood_type_id)>
                                    {{ $bloodType->name }}
                                </option>
                            @endforeach
                        </x-wire-native-select>

                        {{-- Campo para observaciones --}}
                        <x-wire-textarea label="Obervacones" name="observations">
                            {{ old('observations', $patient->observations) }}
                        </x-wire-textarea>
                    </div>

                    {{-- Contacto de Emergencia --}}
                    <div x-show="tab === 'contacto-emergencia'">

                        {{-- Nombre de contacto de emergencia --}}
                        <div class="space-y-4">
                            <x-wire-input label="Nombre del contacto de emergencia" name="emergency_contact_name"
                                value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />

                            {{-- Relación con el contacto de emergecia --}}
                            <x-wire-input label="Relación con el contacto de emergencia"
                                name="emergency_contact_relationship"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />

                            {{-- Teléfono del contacto de emergencia --}}
                            <x-wire-input label="Teléfono del contacto de emergencia" name="emergency_contact_phone"
                                value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                placeholder="Ingrese el número de teléfono del contacto de emergencia" />
                        </div>
                    </div>

                </div>
        </x-wire-card>
```
*En el caso de posibles cambios, aquí el código del commit: [5db96c7](https://github.com/dgroes/cita_medica/commit/5db96c759c8f630362b9627f262ab3cbddcce36b).*
## C42: Descomponiendo Edit en componentes Blade
Previamente en el comentario **C41** se enfocó en el fihcero `resources/views/admin/patients/edit.blade.php`. Pues ahora se hace un cambio importante. Se hace una descomposición de dicha vista en componentes Bale reutilizables, manteniendo el código limpio, organizado y DRY (Don't Repeat Yourself). 
### 1. `<x-tabs>` – Componente contenedor principal
Este componente es el componente raíz del sistema de pestañas. Se encarga de:
- Iniciar **AlpineJS** con un valor reactivo `active` que determina la pestaña activa.
- Renderizar dos slots:
    - `Header`: Donde se colocan los `<x-tab-link>` (las pestañas)
    - el contenido principal (`$slot`): donde se colocan los `<x-tab-content>`.
```php
@props(['active' => 'default'])

<div x-data="{ active: '{{ $active }}' }">
    @isset($header)
        <ul> {{ $header }} </ul>
    @endisset

    <div class="px-4 mt-4">
        {{ $slot }}
    </div>
</div>
```
**Como se usa dentro de `edit.php`:**
```php
<x-tabs active="datos-personales">
    <x-slot name="header">
        <x-tab-link tab="datos-personales">...</x-tab-link>
        <x-tab-link tab="antecedentes">...</x-tab-link>
        ...
    </x-slot>

    <x-tab-content tab="datos-personales">...</x-tab-content>
    <x-tab-content tab="antecedentes">...</x-tab-content>
    ...
</x-tabs>
```
Este componente es el cereblo del sistema: maneja el estado `active` de AlpineJS y lo expone a sus hijos.
**Algo más de contexto:**
En Blade, `{{ $slot }}` representa el **contenido que se pasa desde el componente padre** (el que lo llama) al componente hijo.
En la parte de ``tabs.blade.php``:
```php
<div class="px-4 mt-4">
    {{ $slot }}
</div>
```
Esto quiere decir: dentro del `div` con clases `px-4 mt-4`, voy a renderizar todo el contenido que se ponga dentro del `<x-tabs>` cuando se use.
**Y el contenido que se le pasa al ese slot es:**
```php
<x-tabs active="datos-personales">
    <x-slot name="header">
        {{-- Aquí van los <x-tab-link> --}}
    </x-slot>

    {{-- ESTE contenido va dentro de {{ $slot }} --}}
    <x-tab-content tab="datos-personales">...</x-tab-content>
    <x-tab-content tab="antecedentes">...</x-tab-content>
    <x-tab-content tab="informacion-general">...</x-tab-content>
    <x-tab-content tab="contacto-emergencia">...</x-tab-content>
</x-tabs>
```
Entonces Blade hace internamente lo siguiente:
```php
<div class="px-4 mt-4">
    <x-tab-content tab="datos-personales">...</x-tab-content>
    <x-tab-content tab="antecedentes">...</x-tab-content>
    ...
</div>
```
**Ahora con `x-slot name="header"`:**
Cuando se define el `<x-slot name="header">`, Blade lo interpreta como una variable especial (`$header`), que se puede usar en el contenedor así:
```php
@isset($header)
    <div class="border-b ...">
        <ul> {{ $header }} </ul>
    </div>
@endisset
```
Entonces
- `{{ $slot }}`: Todo lo que está fuera del slot nombreado (contenido por defecto.)
- `$header`: lo que está dentro de `<x-slot name="header">`
### 2. `<x-tab-link> ` – Componente para las pestañas (navegación)
Este componente representa una pestaña (como un botón) que:
- Cambia el valor de `active` cuando se hace clic.
- Muestra estilos distintos dependiendo de si la pestaña está activa o no (`active === '{{ $tab }}'`).
```php
@props(['tab' => 'default'])

<li class="me-2">
    <a href="#" x-on:click="active = '{{ $tab }}'"
       :class="{
           '...text-blue...border-blue...': active === '{{ $tab }}',
           '...hover:border-gray...': active !== '{{ $tab }}'
       }">
        {{ $slot }}
    </a>
</li>
```
**Como se usa en el `edit`:**
```php
<x-tab-link tab="informacion-general">
    <i class="fa-solid fa-info me-2"></i> Información General
</x-tab-link>
```
**Interacción** con `<x-tabs>`: cuando se hace clic en un ``x-tab-link`, cambia el estado `active` del `x-tabs` padre usando `x-on:click="active = 'informacion-general'"`. 
### 3. `<x-tab-content>` – Componente para mostrar contenido condicionalmente
Este componente muesta el contenido de una pestaña solo si está activa, utilizando `x-show`.
```php
@props(['tab' => 'default'])

<div x-show="active === '{{ $tab }}'">
    {{ $slot }}
</div>
```
Interacción en `edit`:
```php
<x-tab-content tab="contacto-emergencia">
    {{-- Aquí va el contenido del formulario para contacto de emergencia --}}
</x-tab-content>
```
**Interacción** con `<x-tabs>`: este contenido se mostrará solo si `active === 'contacto-emergencia'`.
### Todo junto:
- `<x-tabs>` inicializa x-data="{ active: 'datos-personales' }".
- Los `<x-tab-link>` actualizan la variable active al hacer clic.
- Los `<x-tab-content>` se muestran o se ocultan dinámicamente según el valor actual de active.
Todo esto se logra gracias a **AlpineJs** y su sitema de reactividad.
**Importante tener en mente:**
- Flowbire aporta estilos y estrucura, por ejemplo con las clases como `border-b-2`, `rounded-t-lg`, etc.
- WireUI permite usar componentes como `<x-wire-card>`, `<x-wire-imput>`, etc. que mejoran el diseño y funcionalidad de los formularios.
- AlpineJS es el motor que hace posible el cambio de pestañas sin recargar ni usar Livewire.
## C43: Horarios de Doctores
### Ruta
Para crear los registros de horarios de los doctores, primero se deberá crear la ruta.
Dentro del fchero `routes/admin.php`:
```php
Route::get('doctos/{doctor}/schedules', [DoctorController::class, 'schedules' ])
    ->name('doctor.schedule');
```
Entonces la URL será: `/doctos/{doctor}/schedules`, utilizará el controller de Doctor, el método HTTP será `GET` y el nombre de la ruta será `doctor.schedule`.
**Mäs en detalle**
Laravel espera que `{doctor}` sea un ID o una **instancia de modelo** su se usa Route Model Binding. Por ejemplo:
```js
/doctos/5/schedules
```
Se pasará el valor de 5 como argumento el método `schedules`.
### Método en controller
Ahora dentro de su controller deberá estar el siguiente método:
```php
public function schedules(Doctor $doctor){
        return view('admin.doctors.schedules', compact('doctor'));
    }
```
Entonces se deberá crear dicha view: `resources/views/admin/doctors/schedules.blade.php`.
### Doctor action
Ahora además se modificará el action. Agregando un nuevo botón para los horarios del doctor:
```php
/* resources/views/admin/doctors/actions.blade.php */
<x-wire-button href="{{ route('admin.doctor.schedule', $doctor) }}" green xs>
        <i class="fa-solid fa-calendar"></i>
    </x-wire-button>
```
### Componente Livewire
Luego se creará un componente llamado "ScheduleManager": 
```bash
❯ php artisan make:livewire Admin.ScheduleManager
 COMPONENT CREATED  🤙

CLASS: app/Livewire/Admin/ScheduleManager.php
VIEW:  resources/views/livewire/admin/schedule-manager.blade.php
```
Creando la clase y su respectiva view.
### Añadir el componente
Voliendo al fichero `resources/views/admin/doctors/schedules.blade.php` se añadirá lo siguiente para llamar dicho componente:
```php
 @livewire('admin.schedule-manager', ['doctor' => $doctor])
```
## C44: Gestión de horarios
> *Los horarios son los rango de horas en un día en la cual el doctor estará disponible para aceptar una cita*

Previamente, en el comentario C43, se detallaron algunos puntos importantes. Uno de ellos fue la creación de un componente Livewire, el cual dio lugar a la generación de dos archivos: su clase y su vista:
```php
CLASS: app/Livewire/Admin/ScheduleManager.php
VIEW:  resources/views/livewire/admin/schedule-manager.blade.php
```
Desde la vista de horarios del doctor, ubicada en `resources/views/admin/doctors/schedules.blade.php`, se incluye el componente de la siguiente manera:
```php
/* resources/views/admin/doctors/schedules.blade.php */
<x-admin-layout title="Horarios | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Horarios',
    ],
]">

 @livewire('admin.schedule-manager', ['doctor' => $doctor])

</x-admin-layout>
```
En la parte final se realiza el llamado al componente creado, pasándole una información clave: el objeto `doctor`. Gracias a la línea `'doctor' => $doctor`, se le entrega al componente Livewire la instancia del doctor, permitiéndole gestionar sus datos dentro del componente.
Los horarios de los doctores debería estar adaptados al tiempo aproximado que dura una consulta médica. Normalente el tiempo establecido es de 15 minutos. Entonces cuando una persona intenta agendar una consulta en un día en conqueteo genarlmente está establecido así:
```js
08:15 | 08:30 | 08:45 | 09:00 | 09:15
```
Teniendo esto último en mente, se establecerá que **los horarios estarán asignado de 15 mintuos**. Asiendo que si un usuario quiere agendar una cita, este puede tomar dicha cita en un esquema de horario similar al que la talba superior. 
Para finalizar con esta parte faltaría crear una migración y model de Schedules:
```bash
❯ php artisan make:model Schedule -m
INFO  Model [app/Models/Schedule.php] created successfully.  
INFO  Migration [database/migrations/2025_07_23_163413_create_schedules_table.php] created successfully.  
```
Así, con dicho comando se crearían los dos ficheros a la vez. Hasta aquí sería este comment, pero luego de este le seguiran varios los cuales estarán relacionado a este.
## C45: Vinculación entre el componente/models/view/BD
### Fichero `app/Livewire/Admin/ScheduleManager.php`:
Commits de Git en los cuales se basa este comentario extenso:
- 🏗 Componete de Livewire con la migración de Schedules: `f9cb650294c66411afc0cf02110d8de0eb0a4bac`
- 🚀 View de Schedules vinculada al componetes SheduleManager y Pequeño cambio en admin.blade: `25428d5a2ec265a211cab9f378e0fd3a777ac3ad`
- 🎨 View pricipales de Schedules con su Actions: `714cad130b86514ede107f6a493576cf32a2c4af`
- 🚚 Ruta de Calendario por doctor y ruta de prueba: `57aa92128a53e5adb42aa36b6a281a7e1e3feb00`
#### 01. Casteo de los datos
Lo último que se hizo en el comentario previo **(C44)** fue la creación del modelo y migracion de **Schedule**. Ahora se deberá actualizar dicho modelo.
Además de los datos en `protected` y la relación con `doctor` se realiza un casteo de los datos:
```php
protected $casts = [
        'day_of_week' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
```
El `cast` en un model de Laravel se usa para **convertir automáticamente** los valores de los atributos cuando se almacenan o se accede a ellos desde el modelo. En el caso del código previo Laravel haría lo siguiente:
- `'day_of_week' => 'integer'`: Siempre que accedas o guardes este atributo, Laravel se asegurará de que sea un número entero.
- `'start_time'` y `'end_time'` como `datetime`: Laravel convertirá estos valores en instancias de Carbon (una extensión de DateTime), lo que permite usar métodos como `->format()`, `->diffForHumans()`, etc.
Además convierte automáticamente de formatos como `"2025-07-23T12:00:00.000000Z"`(formato ISO 8601) a `"2025-07-23 12:00:00"` cuando se accese al valor o se guarda en la BD.
>Debe estar en `protected` porque es una propiedad de configuración interna del modelo. Laravel internamente accede a esta propiedad para saber qué tipo de conversión debe aplicar. Si se define como `public`, se podría exponer esa configuración y romper el encapsulamiento del model.
#### 02. Componente Schedule
Luego de crear el componente Livewire `app/Livewire/Admin/ScheduleManager.php` el cual es un componente de tipo "class-based". el cual:
- Extiende de `Livewire/Component`
- Vive dentro del espacio de nombre `App\Livewire\Admin`
- Tiene su vista correspondiente en `resources/views/livewire/admin/schedule-manager.blade.php`.
Ok. Este componente es el pricipal fichero para la **gestión de los horarios de un doctor** aquí las partes clave:
#### 03. Propiedades publicas
```php
public Doctor $doctor;
public $schedule = [];
public $days = [...];
public $apointment_duration = 15;
public $intervals;
```
- `$doctor`: se espera que se pase un objeto `Doctor` cuando se monte el componente.
- `$schedule`: matriz de días y horas (ej. Lunes a las 08:00 tiene disponibilidad).
- `$days`: mapea los días de la semana con su nombre (Carbon usa 0 para domingo).
- `$apointment_duration`: duración de cada bloque de cita (por defecto 15 min).
- `$intervals`: cuántos bloques de duración caben en una hora.
#### 04. Propiedad computada:
Lo primero: Una propiedad computada es una función pública que se define en el componente y se comporta **como si fuera una propiedad**, pero su valor es **calculado automáticamente** cada vez que se accede a ella, en lugar de ser almacenado directamente.
Se usa para **evitar lógica repetida** y mantener el código limpio. Entonces llegamos a esto:
```php
#[Computed()]
    public function hourBlocks()
    {
        return CarbonPeriod::create(
            Carbon::createFromTimeString('08:00:00'),
            '1 hour',
            Carbon::createFromTimeString('18:00:00')
        );
    }
```
Cuando se escribe `$this->hourBlocks` Livewire sabe que eso en realidad se refiere al resultado de la funci+on `hourBlocks()`. Se ejecuta dinámicamente **cada vez que se accede**, como si fuera una propiedad calculada. Logrando:
- Evita duplicar lógica: Si se necesita ese período en múltiples lugares, solo se define una vez.
Entonces dicho método `hourBlocks()` **genera un período de bloques por cada hora entre 08:00 y 18:00** ejemplo: 08:00 -> 09:00 -> 10:00
#### 05. Método `initialize`:
Este método llena la matriz `$schedule` con los horarios del doctor recorriendo:
- Cada hora (ej. 08:00, 09:00…)
- Dividiendo cada hora en intervalos de 15 minutos (por defecto)
- Revisando si ese `day_of_week` y `start_time` existen en los horarios del doctor (`$schedules`)`
Marca como un `true` o `false` si existe disponibilidad para ese bloque de 15 minutos.
#### 06. Método `save`
De momento dicho método tiene lo siguiente:
```php
public function save()
    {
        dd($this->schedule);
    }
```
Haciendo que cuando se le de clic a wireUI button que está en el fichero `resources/views/livewire/admin/schedule-manager.blade.php`, más en concreto al botón:
```html
 <x-wire-button wire:click="save">
    Guardar Horario
</x-wire-button>
```
LLama al método `save`y este devuelte el `dd` que en este caso sería:
```json
array:7 [▼ // app/Livewire/Admin/ScheduleManager.php:72
  1 => array:45 [▼
    "08:00:00" => true
    "08:15:00" => false
    "08:30:00" => false
    "08:45:00" => false
    "09:00:00" => false
    "09:15:00" => false
    "09:30:00" => false
    ... .... ....
     2 => array:45 [▶]
  3 => array:45 [▶]
  4 => array:45 [▶]
  5 => array:45 [▶]
  6 => array:45 [▶]
  0 => array:45 [▶]
```
En este punto de escritura hay un horario que es entre la 08:00 y 08:15, por eso devuelve el `true` que se establece en el método `initialize`. 
### View `resources/views/livewire/admin/schedule-manager.blade.php`:
Este fichero está vinculado estrechamente con el componente Livewire: `ScheduleManager.php`, Además se hace uso de Alpine.js para la partes de interactividad del frontend.
```php
/* Commit: 25428d5a2ec265a211cab9f378e0fd3a777ac3ad*/
/* resources/views/livewire/admin/schedule-manager.blade.php */
<div x-data="data()">
    <x-wire-card>
        <div class="mb-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">
                Gestor de horarios
            </h1>
            <x-wire-button wire:click="save">
                Guardar Horario
            </x-wire-button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-yellow-400">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 tracking-wider">
                            Día/Hora
                        </th>
                        @foreach ($days as $day)
                            <th class="px-6 py-4">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($this->hourBlocks as $hourBlock)
                        @php
                            $hour = $hourBlock->format('H:i:s');
                        @endphp
                        <tr>
                            {{-- explicar nowrap --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <label for="">
                                    <input type="checkbox"
                                        class="size-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                    <span class="font-bold ml-2">
                                        {{ $hour }}
                                    </span>
                                </label>
                            </td>
                            @foreach ($days as $indexDay => $day)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-2">
                                        <label for="">
                                            <input type="checkbox"
                                                class="size-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                            <span class="ml-2 text-sm text-gray-700">
                                                Todos
                                            </span>
                                        </label>
                                        @for ($i = 0; $i < $intervals; $i++)
                                            @php
                                                $startTime = $hourBlock->copy()->addMinutes($i * $apointment_duration);
                                                $endTime = $startTime->copy()->addMinutes($apointment_duration);
                                            @endphp
                                            <label for="">
                                                <input type="checkbox"
                                                    x-model="schedule['{{ $indexDay }}']['{{ $startTime->format('H:i:s') }}']"
                                                    class="size-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                                <span class="ml-2 text-sm text-gray-700">
                                                    {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
                                                </span>
                                            </label>
                                        @endfor
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </x-wire-card>

    @push('js')
        <script>
            function data() {
                return {
                    schedule: @entangle('schedule')
                }
            }
        </script>
    @endpush
</div>
```
Ahora las partes importantes en base a los horarios de los doctores: 
#### 0: Otras concluciones 
##### 1. Encabezado de la tabla con los días:
```php
@foreach ($days as $day)
    <th class="px-6 py-4">
        {{ $day }}
    </th>
@endforeach```
Recorre el array $days, que está definido en el componente Livewire `ScheduleManager.php`:
```php
// app/Livewire/Admin/ScheduleManager.php
public $days = [
    1 => 'Lunes',
    2 => 'Martes',
    3 => 'Miércoles',
    4 => 'Jueves',
    5 => 'Viernes',
    6 => 'Sábado',
    0 => 'Domingo'
];
```
Por cada día, genera una celda `(<th>)` en la cabecera de la tabla. Así se construye una fila con los días de la semana, en la parte superior de la tabla.
##### 2. Cuerpo de la tabla (matriz de horario):
```php
@foreach ($this->hourBlocks as $hourBlock)
```
Esta sección construye el cuerpo de la tabla de horarios con:
- Filas por bloque horario (ej. 08:00, 09:00...)
- Columnas por día de la semana
- Checkboxes por cada intervalo (ej. 15 min) dentro de esa hora.
**🔍 ¿Qué hace paso a paso?**
01. `@foreach ($this->hourBlocks as $hourBlock)`
`$hourBlocks` es una propiedad computada que define bloques horarios entre las 8:00 y las 18:00:
```php
// app/Livewire/Admin/ScheduleManager.php
public function hourBlocks() {
    return CarbonPeriod::create(
        Carbon::createFromTimeString('08:00:00'),
        '1 hour',
        Carbon::createFromTimeString('18:00:00')
    );
}
```
02. **Dentro de cada hora:**
Se divide cada bloque horario (ej. de 08:00 a 09:00) en intervalos de 15 minutos, usando un @for:
```php
@for ($i = 0; $i < $intervals; $i++)
    $startTime = 08:00 + (i * 15 minutos)
    $endTime = $startTime + 15 minutos
```
03. Checkbox de intervalos:
Cada uno genera:
```html
<input type="checkbox" x-model="schedule['{{ $indexDay }}']['{{ $startTime->format('H:i:s') }}']" />
```
Esto crea un checkbox conectado al array schedule de **AlpineJS**, que está sincronizado con la propiedad de Livewire:
```php
x-model="schedule[day][hora]"
```
04. **¿Y qué hace esto?**
**Marca como activo o inactivo cada intervalo del horario semanal del doctor**. Visualmente, es una matriz de checkboxes por hora y día.

05. **❓¿Qué es whitespace-nowrap?**
En el td, esta clase evita que el contenido del texto se divida en varias líneas. Es decir, hace que los rangos horarios se mantengan en una sola línea horizontal, sin saltos:
```html
<td class="px-6 py-4 whitespace-nowrap">
```
06. Script de AlpineJS sincronizado con Livewire:
```php
@push('js')
    <script>
        function data() {
            return {
                schedule: @entangle('schedule')
            }
        }
    </script>
@endpush
```
**📌 ¿Qué hace?**
Define la función data() para Alpine.js, que se activa por x-data="data()". Dentro de data(), se define un objeto con schedule conectado directamente a Livewire:
`schedule: @entangle('schedule')`
**🔄 ¿Qué es @entangle?**
Es una utilidad de Livewire que conecta una propiedad de PHP (`$schedule`) con una variable JS (`schedule`) en tiempo real y bidireccional. Cuando marcas un checkbox, el cambio se sincroniza automáticamente con la propiedad $schedule en el backend sin necesidad de refrescar.

| Día/Hora | Lunes                                      | Martes   | ... |
| -------- | ------------------------------------------ | -------- | --- |
| 08:00    | \[x] 08:00 - 08:15 <br> \[ ] 08:15 - 08:30 | \[x] ... | ... |
| 09:00    | \[ ] 09:00 - 09:15 <br> \[x] ...           | \[ ] ... | ... |
| ...      | ...                                        | ...      |     |
Cada casilla representa un slot horario activo/inactivo, que se sincroniza en vivo con Livewire.
#### 01. `@entangle('schedule')` Conección entre Alpine y Livewire
```php
schedule: @entangle('schedule')
```
Esto enlaza bidireccionalmente la propiedad `public $schedule` del componente Livewire `ScheduleManager` con Alpine.js. Es decir, cualquier cambio en los checkboxes del HTML afectará directamente a `$schedule` en el backend, y viceversa. Y se usa dentro de la función data `data()` para `x-data`.
#### 02. `$this->hourBlocks` Generar los bloques de hora
```php
@foreach ($this->hourBlocks as $hourBlock)
```
`hourBlocks` Es otra propiedad del componente `ScheduleManager`. y se usa para generar filas por cada franja horaria
#### 3. `@foreach ($days as $day)` Días de la semana
```php
@foreach ($days as $day)
```
`days` es una propiedad pública/computada del componente Livewire y define que días se mostrarán como columnas, por ejemplo, lunes a domingo.
#### 4. `@for ($i = 0; $i < $intervals; $i++)` Intervalos dentro de cada bloque horario
```php
$startTime = $hourBlock->copy()->addMinutes($i * $apointment_duration);
```
Aquí se generan subbloques horarios dentro del bloque principal 08:00-08:15, 08:15-08:30, etc. Esto depende de dos variables definias en `ScheduleManager`
- `$intervals`: Cuantos intervalos se crearn por bloque
- `$apointment_duration` duración en minutos de cada intervalo
#### 5. `wire:click="save"` Método del componente Livewire
```php
<x-wire-button wire:click="save">
    Guardar Horario
</x-wire-button>
```
El botón ejecuta el método `save()` en el componente `ScheduleManager`. Este método procesa y guardaría los datos del horario almacenados.
#### 6. Alpine.js y Livewire integrados
```html
<div x-data="data()">
...
<script>
    function data() {
        return {
            schedule: @entangle('schedule')
        }
    }
</script>
```
```php
x-model="schedule['{{ $indexDay }}']['{{ $startTime->format('H:i:s') }}']"
``` 
Hace que cada checkabox de intervalo esté directamente ligado a una posición específica del array `$schedule`. Por ejemplo:
```php
$schedule[1]['08:00:00'] = true
```
Indica que el primer checkbox del martes a las 08:00 está activado
#### 07. `whitespace-nowrap`
Dentro de la view hay clases que tiene lo siguiente:
```html
<td class="px-6 py-4 whitespace-nowrap">
```
Esta es una clase de Tailwind CSS que **evita que el texto se divida en varias líneas**, es decir, **no hace saltos de línea automáticos**
### Modelos y Migracion
Se establece la relacion entres los modelos de Doctos y Schedule:
```php
// app/Models/Doctor.php
public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
```
Y la relación inversa sería:
```php
// app/Models/Schedule.php
public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
```
Además de tener dicha relación en la migración de Schedule:
```php
// database/migrations/2025_07_23_163413_create_schedules_table.php
Schema::create('schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('doctor_id')
          ->constrained()
          ->onDelete('cascade');
    $table->unsignedTinyInteger('day_of_week'); 
    $table->time('start_time');
    $table->time('end_time'); 
    $table->timestamps();
});
```
### StackJS
Dentro del fihcero `resources/views/layouts/admin.blade.php` está lo siguiente:
```html
<head>
    @stack('css')
</head>
<body>
    {{-- contenido --}}
    
    @stack('js') <!-- justo antes de cerrar el body -->
</body>
```
Lo que hace esas 2 adiciones es permitir que cualquier vista hija que lo use pueda inyectar scripts o estilos en esos puntos usando:
- `@push('js'`: Para inyectar JS donde está `@stack('js')`
- `@push('css')`: Para inyectar CSS donde está `@stack('css')`
Ahora esta adición a dicho fichero es debido a la vinculación entre el `admin.blade.php` y `admin/schedule-manager.blade.php`. Analizando el segundo fichero se tiene esto:
```php
// resources/views/livewire/admin/schedule-manager.blade.php
@push('js')
    <script>
        function data() {
            return {
                schedule: @entangle('schedule')
            }
        }
    </script>
@endpush
```
Esto está empujando un bloque de JS a la pila `js`, y gracias a que el layout principal tiene un `@stack('js')`, ese script será insertado automáticamente ahí, justo antes de cerrar el `<body>`
Esto llega a ser útil porque separa responsabilidades
- El componente Livewire puede definir sus scripts sin tener que editar el layout principal
- El layout solo neceita tener `@stack('js')` y `@stack('css')`, y los componentes o vistas que lo usen pueden inyectar contenido extra cuando lo necesiten.
Entonces gracias a esto
- El layout es lipio y reutilizable
- Los scripts necesarios para `x-data="data()` de (Alpine.js) llegan correctamente.
- Livewire puede hacer binding con `@entangle('schedule')` sin errores de JS
##
