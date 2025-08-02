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
## C46: Marcado de horarios
Dentro del fichero `resources/views/livewire/admin/schedule-manager.blade.php` hay columnas de los días de la semana en base a las horas del día entre 1 hora. Creando los ckecks para marcar los horarios, dentro de ahí está el botón todos para el día y todos para la hora completa. Para que dichos ckecks funcione se deberá crear unos métodos.
>Antes de seguir con los métodos es importante tener en cuenta lo siguiente: 
> - `$el` es una referencia al input actual en Alpine.js
>  - `$el.checked` dice si el checkbox está activo
>  - `:checked="..."` es la forma reactiva de Alpine para marcar o desmarcar inputs en base a un valor booleano.

| Acción                                              | Método                     |
| --------------------------------------------------- | -------------------------- |
| Marcar toda una hora en un día                      | `toggleHourBlock()`        |
| Ver si toda una hora en un día está marcada         | `isHourBlockChecked()`     |
| Marcar toda una hora en todos los días              | `toggleFullHourBlock()`    |
| Ver si toda una hora en todos los días está marcada | `isFullHourBlockChecked()` |

### Primer Método:**
```js
toggleHourBlock(indexDay, hourBlock, checked) {
    let hour = new Date(`1970-01-01T${hourBlock}`);
    for ($i = 0; $i < this.intervals; $i++) {
        let startTime = new Date(hour.getTime() + ($i * this.apointment_duration * 60000));
        let formattedStartTime = startTime.toTimeString().split(' ')[0];
        this.schedule[indexDay][formattedStartTime] = checked;
    }
}
```
Este método activa o desactiva **todos los intervalos de una hora específica para un solo día.**
- Convierte el `hourBlock` (ej: `"08:00:00"`) en un objeto `Date`
- Luego hace un bucle por la cantidad de `intervals`(por ejemplo,4 veces si cada intervalo es de 15 minutos)
- Calcula los horarios de inicio (`startTime`) de cada intervalo: `08:00`, `08:15`, `08:30`, etc.
- Marca cada uno en el array `schedule[indexDay][hora]` como `true` o `false` según `checked`.
### Segundo método
```js
isHourBlockChecked(indexDay, hourBlock) {
    let hour = new Date(`1970-01-01T${hourBlock}`);
    for ($i = 0; $i < this.intervals; $i++) {
        let startTime = new Date(hour.getTime() + ($i * this.apointment_duration * 60000));
        let formattedStartTime = startTime.toTimeString().split(' ')[0];
        if (!this.schedule[indexDay][formattedStartTime]) {
            return false;
        }
    }
    return true;
}
```
Este verifica si **todos los intervalos de una hora específica están activados** par un día determinado
- Igual que `toggleHourBlock`, recorre los intervalos.
- Si encuentra al menos uno desactivado (`false` o `undefined`), devuelve false.
- Si todos están activos, devuelve `true`.
Este valor es usado para marcar el checkbox "**Todos**" de ese bloque horario de un día como marcado si todos sus intervalos está activos:
```php
:checked="isHourBlockChecked('{{ $indexDay }}', '{{ $hour }}')"
```
### Tercer método
```js
toggleFullHourBlock(hourBlock, checked) {
    Object.keys(this.days).forEach((indexDay) => {
        this.toggleHourBlock(indexDay, hourBlock, checked);
    });
}
```
Marca o desmarca todos los intervalos de esa **hora en todos los días**.
- Recorre todos los días (`indexDay`)
- Llama internamente a `toggleHourBlock(...)` por cada día
Este se hace uso en el siguiente checkbox:
```html
<input type="checkbox"
    x-on:click="toggleFullHourBlock('{{ $hour }}', $el.checked)"
    :checked="isFullHourBlockChecked('{{ $hour }}')" />
```
### Cuarto método
```js
isFullHourBlockChecked(hourBlock) {
    return Object.keys(this.days).every((indexDay) => {
        return this.isHourBlockChecked(indexDay, hourBlock);
    });
}
```
Este método verifica si **todos los días tienen todos los intervalos activos** en esa hora
- Recorre los días (`indexDay`) con `.every()`
- Si algún día no están todos los intervalos activos -> devuelve `false`
Este valor determina si el checkbox principal de una fila (una hora) debe aparecer marcado o no:
```php
:checked="isFullHourBlockChecked('{{ $hour }}')"
```
## C46: Alerta de SweetAlert2 con Livewire
Dentro del fichero `app/Livewire/Admin/ScheduleManager.php` en el método de creación (`save()`) está lo siguiente:
```php
$this->dispatch(
            'swal',
            icon: 'success',
            title: 'Horario guardado correctamente',
            text: 'El horario del doctor ha sido actualizado.'
        );
```
Lo que hace `dispatch` es **emitir un evento desde un componente Livewire al navegador**. Este evento luego es escuchado por JavaScript en el layout `resources/views/layouts/admin.blade.php` de la siguiente forma:
```html
<!-- resources/views/layouts/admin.blade.php  -->
<script>
        Livewire.on('swal', (data) => {
            Swal.fire(data)
        })
</script>
```
Entonces es ecuchado por JavaScript en el layout usando SweetAlert. el evento creado en el método se llama `swal`. El cual sería un **evento Livewire con un array de datos** enviados al frontend.
Usualmete se haría el contenido de `swal` con un array así:
```php
$this->dispatch('swal', [
    'icon' => 'success',
    'title' => 'Horario guardado correctamente',
    'text' => 'El horario del doctor ha sido actualizado.'
]);
```
Sin embargo, no es necesario y lo recomendable sería sin un formato array y que seá como se monstró previamente. 
## C47: Archivo de configuración personalizado
**Cambios:**
Además de lo principal de este comentario, es importante que hasta este punto se relizaron cambios.
- La migración `database/migrations/2025_07_23_163413_create_schedules_table.php` ya no tiene `end_time`
- El model `app/Models/Schedule.php` Ya no posee `end_time`

La propiedad `end_time` no estaba siendo utilizada y no aportaba valor en la lógica actual del sistema. Dado que lo realmente relevante es la hora de inicio (`start_time`), se optó por eliminar el campo para simplificar la estructura y aumentar la flexibilidad futura. Esto permitirá adaptar los horarios sin estar limitados a una hora de término fija.

En Laravel existen los ficheros llamados **"archivos de configuración personalizados"**. Estos son creados manualmente dentro del directorio `config/`, que es donde Laravel guarda toda la configuración del sistema. 
Laravel permite que se puedan acceder ahí facilmente. en este caso `config/schedule.php` guarda parámetros reutilizables para la gestión de horarios.
```php
// app/Livewire/Admin/ScheduleManager.php
$this->days = config('schedule.days');
    $this->apointment_duration = config('schedule.appoiment_duration');
    $this->start_time = config('schedule.start_time');
    $this->end_time = config('schedule.end_time');
```
Su acceso con se puede ver se sencillo, con `config` segido del nombre del fichero y el dato.
### Ventajas de usar archivos `config/`
1. **Centralización de valores constantes**
En vez de repetir valores como "`08:00:00`" o "`Lunes`" por todo el código, los defines una sola vez.
2. **Facilidad para cambiar parámetros**
Si algún día quieres cambiar la hora de inicio a "`09:00:00`", lo haces una vez en `config/schedule.php` y se actualiza en todo el sistema.
3. **Separación de lógica y configuración**
El código (`ScheduleManager`) se concentra en su funcionalidad, y no se ensucia con valores mágicos (hardcoded).
4. **Escalabilidad**
Si en el futuro necesitas múltiples configuraciones por tipo de usuario o clínica, puedes expandir este archivo fácilmente.
## C48: Enum personalizado
En este punto se crearon los ficheros de model y migrate de `Appoiment`, dentro de la creación de la tabla está la línea:
```php
$table->tinyInteger('status')->default(1);
```
Está la opción de usar un `enum`, similar a esto:
```php
$table->enum('status', [
                '1' => 'Scheduled',
                '2' => 'Completed',
                '3' => 'Cancelled'
            ])->default('1');
```
Pero de esta segunda forma no puede ser escalable a futuro, si quisiera agregar un nuevo estatud se debería modificar la migración, eso no es bueno.
Con el comando `php artisan make:enum AppointmentEnum` se creará un fichero `enum` de PHP. Pero antes, un **enum (enumeración)** es un tipo de clase que representa un conjunto fijo de valores posibles. En vez de usar números "mágicos" o constantes sueltas (`1`, `2`, `3`), se le **puede darles un nombre legible y significativo**
```php
// app/Enums/AppointmentEnum.php
<?php

namespace App\Enums;

enum AppointmentEnum: int
{
    case SCHEDULED = 1;
    case COMPLETED = 2;
    case CANCELLED = 3;
}
```
En este fihcero se definen 3 estados posibles para una cita(`appoiment`). En lugar de escribir un código como: `$appointment->status === 2` se puede hacer algo mejor: `$appointment->status === AppointmentEnum::COMPLETED`, añadiendo **más legibilidad, menos errores, más mantenible**
Ahora su relación en este caso está con `Appoiment`, entonces debería estar esto en el modelo:
```php
// app/Models/Appointment.php
protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => AppointmentEnum::class,
    ];
```
Está dentro de `$casts`. Aquí lo que se le dice a Laravel sería: *Cuando lea el campo `status` de la base de datos, conviértelo automáticamente al tipo `AppointmentEnum`. Y cuando lo guarde, conviértelo desde `AppointmentEnum` al número correspondiente.*
**Dando ventajas:**
- Se **evita confusión** con números.
- Se **centraliza** los posibles estados.
- Se puede añadir **métodos personalizados** en el enum si se desea.
- Funciona bien con validaciones o formularios (`$enum->name`, `$enum->value`, etc.).
## C49: Buscador de citas médicas (1)
Comentario con el comentario anterior y en base a los avances de los commits: 
- 63132130165299db3cd453030ab1b6274b7ffb15
- d4774487bafcbdbd0c24a22d7c6dc14aa62a236b
- 572ca0cbf330c6ca2c1b033335ecbcf8e5ded034
- a68da47dd76beda40d0eae47b4d30f5e3b4ab998
- 0c3d6d154aace1becc9e94b2b2d3912194b7ca8c
- 026aefd71a369b9c5756e4719ed5c3585d367d43

Para tener una visualización de los datos relacionado a una cita, es decir, doctor, día, hora, especialidad, etc. Se creó el siguiente componente Livewire:
```bash
php artisan make:livewire Admin/AppointmentManager
-> app/Livewire/Admin/AppointmentManager.php
-> resources/views/livewire/admin/appointment-manager.blade.php
```
### La View
Lo primero, dentro de `resources/views/livewire/admin/appointment-manager.blade.php` estará el frontal, tentiendo partes importantes como:
```html
<x-wire-input
    label="Fecha"
    type="date"
    wire:model="search.date"
    placeholder="Selecciona una fecha"
/>
```
Dentro del fichero hay un `x-wire-input` y dos`x-wire-select` además un botón con `wire:click="searchAvailability"`. **Livewire permite crear componentes interactivos y dinámicos** usando Blade + PHP, **sin usar JS directamente** como sería este caso. Entonces `wire:model` y `wire:click`, etc. son "**directivas de Livewire**" que **conectan HTML del componente (Blade) con la clase Livewire correspondiente**.
1. **Binding bidireccional**
En `wire:model="search.date"` pasa lo siguiente:
- Se hace binding bidireccional (dos vías) entre el input y el compoente PHP
- En la clase `AppointmentManager` se tiene lo siguiente:
```php
public $search = [
    'date' => '',
    'hour' => '',
    'speciality_id' => '',
];
```
- Entonces, cada vez que el usuario selecciona una **nueva fecha**, automáticamente se actualiza `$search['date']` en el componente Livewire sin recargar la página.
- Si desde PHP se cambia `$this->search['date']` tambien se actualiza en el input en tiempo real.
2. **Botón ejecutador**
El componente botón posee dentro de el `wire:click="searchAvailability"` lo que hace:
- le dice a Livewire que **ejecute el método** `searchAvailability()` del componente Livewire (`AppointmentManager.php`) **cuando se haga clic en el botón**
- Es como un `@click` de Vue, o un `onclick`, pero funciona sin tener que escribir JS manualmente
3. **Que hacen los estados?**
Entonces está `wire:model`, esto es la forma en que Livewire **"escucha" y sincroniza automáticamente los inputs del frontend con el backend PHP**. es decir:
- Cada input queda enlazado con una **propiedad pública del componente PHP**
- Livewire se encarga del estado, del DOM, del AJAX y del renderizado parcial, **todo automáticamente**.
- Esto internamente funcioaría así
    - **Livewire** usa **AJAX por detrás del DOM**, cada vez que un dato cambia o haces clic en un botón.
    - Actualiza el backend con ese valor.
    - Ejecuta el método correspondiente (como `searchAvailability`)
    - Y devuelve solo el fragmento del HTML que cambió (sin recargar la página entera).
### La clase
1. **Propiedades public del componente**
En la sección: 
```php
public $search = [
    'date' => '',
    'hour' => '',
    'speciality_id' => '',
];

public $specialties = [];
```
Aquí `$search` guarda los datos ingresados por el usuario en el buscador (fecha, hora y especialidad). Almacenados para luegos hacer la búsqueda. Con `specialties` se contendrá todas las especialidades disponibles (consultadas en la BD en `mount()`).
2. Método ``mount()` 
En el método está lo siguiente:
```php
public function mount()
{
    $this->specialties = Speciality::all();

    # Sacar hora actual
    $this->search['date'] = now()->hour >= 12
        ? now()->addDay()->format('Y-m-d')
        : now()->format('Y-m-d');
}
```
- Al ser un método `mount` (**componente de Livewire que se ejecuta una sola vez al momento de inicializar o montar el componente en la vista**) hace la inicialización del componente.
- Carga toas las especialidades desde la BD.
- Si la hora actual es espues de las 12:00, se establece la fecha por defecto como el **día siguiente**, si es antes, se una el **día actual**
    - Esto impide que se pueda agendar en el mismo día si ya es muy tarde.
4. Propieda computada. 
Al igual que está en `app/Livewire/Admin/ScheduleManager.php` aquí tenemos, pero con alguna diferencia:
```php
#[Computed()]
public function hourBlocks()
{
    return CarbonPeriod::create(
        Carbon::createFromTimeString(config('schedule.start_time')),
        '1 hour',
        Carbon::createFromTimeString(config('schedule.end_time'))
    )->excludeEndDate();
}
```
- Devuelve un rango de bloques horarios desde `start_time` hasta `end_time` en intervalos de 1 hora. 
- Usa la una configuración de `config/schedule.php`, mencionado en **C47**. (ejemplo: `"start_time" => "08:00" ` y `"end_time" => "18:00")`).
- El `excludeEndDate()` impide que se incluya la última hora (como `18:00-19:00`).
5. **Método principal**
Este método es llamado cuando se quiere buscar disponibilidad. (el click de la view: `wire:click="searchAvailability"`).
```php
public function searchAvailability(AppointmentService $service)
{
    $this->validate([
        'search.date' => 'required|date|after_or_equal:today',
        'search.hour' => [
            'required',
            'date_format:H:i:s',
            Rule::when($this->search['date'] === now()->format('Y-m-d'), [
                'after_or_equal:' . now()->format('H:i:s'),
            ])
        ],
    ]);
}
```
- Valida que la fecha sea obligatoria, con formato válido y igual o posterior a hoy.
- Valida que la hora sea obligatoria y conformato `H:i:s`.
- Valida si la fecha es **hoy**, la hora debe ser igual o posterior a la hora actual.
6. **Servicio como parámetro**
Al definir el método `searchAvailability` pasa lo siguiente:
```php
public function searchAvailability(AppointmentService $service)
```
Como se puede ver, el método **está recibiendo un servicio(`AppointmentService`) como parametro**. Técnica común en Laravel llamada: "**Inyección de dependencias (Dependency Injection)**". *Saber más del servicio en **C50***.
Laravel tiene un **contenedor de servicios** que es capaz de detectar automáticamente las clases que necesita un método y crearlas e inyectarlas automáticamente. Entonces cuando se hace `public function searchAvailability(AppointmentService $service)` Laravel dice internamente: *"Este método necesita un `AppointmentService` ¿existe una clase asi? Si!!, entonces la creo automáticamente y la paso como argumento"*
7. **Buscado de la disponibilidad**:
Dentro del método `searchAvailability` luego de la validación está
```php
$availability = $service->searchAvailability(...$this->search);
```
Esto llama al método `searchAvailability()` del servicio, inyectado automáticamente por Livewire. Y usa un **operador de desempaquetado** `...` para pasar `date`, `hour` y `speciality_id` como argumentos individuales.
8. **Conexión a la view**
Todo esto funcioa gracías al render:
```php
public function render()
{
    return view('livewire.admin.appointment-manager');
}
```
Que devuelve la vista que se rendiza las propiedades como `$specialities` y los resultados de la busqueda
## C50: Buscador de citas médicas (2)
Comentario con el comentario anterior y en base a los avances de los commits: 
- 63132130165299db3cd453030ab1b6274b7ffb15
- d4774487bafcbdbd0c24a22d7c6dc14aa62a236b
- 572ca0cbf330c6ca2c1b033335ecbcf8e5ded034
- a68da47dd76beda40d0eae47b4d30f5e3b4ab998
- 0c3d6d154aace1becc9e94b2b2d3912194b7ca8c
- 026aefd71a369b9c5756e4719ed5c3585d367d43

Luego de crear la migración, modelo y controlador y sus views principales para `Appointment`. Se crea ahora un nuevo componente Livewire:
```bash
php artisan make:livewire Admin/AppointmentManager
```
Creando así los ficheros: `app/Livewire/Admin/AppointmentManager.php` y `resources/views/livewire/admin/appointment-manager.blade.php`. Además de esto se deberá crear un Service: `app/Services/AppointmentService.php`.
Un **Service** es una clase cuya responsabilidad es **encapsular lógica de negocio compleja o reutilizable** que no encaja directamente en un modelo, controlador o componente Livewire. Es similar a la función de un **helper**, pero con un enfoque más organizado, mantenible y orientado a buenas prácticas. Aquí algunas diferencias entre **Helper** y **Service**.
| Helper                                      | Service                             |
| ------------------------------------------- | ----------------------------------- |
| Funciones sueltas (a veces globales)        | Clases con métodos bien definidos   |
| Sin estado, procedural                      | Orientado a objetos                 |
| Difícil de testear o mantener cuando crecen | Más limpio, testeable y desacoplado |
| Rápido para cosas simples                   | Escalable para lógica compleja      |
En base a este caso, la clase `AppointmentService` sería la encargada de encapsular la lógica compleja de la obtención de doctores disponibles con sus horarios y turnos para poder agendar una cita médica.
Este **Service** es llamado `app/Livewire/Admin/AppointmentManager.php` dentro de su método publico: `searchAvailability`. Se separa dicha lógica y metida en un **Service** para:
- **Evitar sobrecargar el componente Liveweire** (`AppointmentManager`)
- **Separar responsabilidades (SRP del SOLID)**
- **Reutilizar esa lógica desde otros lugares** (por ejemplo desde un Job, Controller o API)
### La consulta
Actualmente la consulta sería:
```php
$doctors = Doctor::whereHas('schedules', function ($q) use ($date, $hourStart, $hourEnd) {
            $q->where('day_of_week', $date->dayOfWeek)
                ->where('start_time', '>=', $hourStart)
                ->where('start_time', '<', $hourEnd);
        })
            ->when($speciality_id, function ($q, $speciality_id) {
                return $q->where('speciality_id', $speciality_id);
            })
            ->with([
                'user',
                'speciality',
                'schedules' => function ($q) use ($date, $hourStart, $hourEnd) {
                    $q->where('day_of_week', $date->dayOfWeek)
                        ->where('start_time', '>=', $hourStart)
                        ->where('start_time', '<', $hourEnd);
                },
                'appointments' => function ($q) use ($date, $hourStart, $hourEnd) {
                    $q->whereDate('date', $date)
                        ->where('start_time', '>=', $hourStart)
                        ->where('start_time', '<', $hourEnd);
                }
            ])
            ->get();
```
Si se pudiera hacer un paralelismo a un SQL script sería:
```sql
SELECT d.*
FROM doctors d
JOIN schedules s ON s.doctor_id = d.id
LEFT JOIN appointments a ON a.doctor_id = d.id
    AND a.date = '2025-08-01'
    AND a.start_time >= '09:00:00'
    AND a.start_time < '10:00:00'
WHERE s.day_of_week = 5 -- (Ej: si es viernes)
  AND s.start_time >= '09:00:00'
  AND s.start_time < '10:00:00'
  AND (d.speciality_id = 3) -- si se pasa speciality_id
GROUP BY d.id;
```
Si en un ejemplo con `dd` se le hiciera a la consula devolvería algo así:
```json
array:1 [▼ // app/Services/AppointmentService.php:46
  0 => array:12 [▼
    "id" => 9
    "user_id" => 9
    "speciality_id" => 9
    "medical_license_number" => "MED789345"
    "biography" => "Dr. Petyr Baelish es un traumatólogo experto en lesiones y enfermedades del sistema musculoesquelético."
    "is_active" => 1
    "created_at" => "2025-07-30T20:11:46.000000Z"
    "updated_at" => "2025-07-30T20:11:46.000000Z"
    "user" => array:13 [▶]
    "speciality" => array:5 [▶]
    "schedules" => array:4 [▼
      0 => array:6 [▼
        "id" => 96
        "doctor_id" => 9
        "day_of_week" => 5
        "start_time" => "2025-07-31T12:00:00.000000Z"
        "created_at" => "2025-07-31T05:40:23.000000Z"
        "updated_at" => "2025-07-31T05:40:23.000000Z"
      ]
      1 => array:6 [▶]
      2 => array:6 [▶]
      3 => array:6 [▶]
    ]
    "appointments" => []
  ]
]
```
Devolviendo todos los doctores activos que tienen un horario disponbile ese día y hora, si pertenece opcionalemnte a la especialidad `9` que sería "Traumatología".
## C51:
## C52:
## C53:
## C54:
## C55:
## C56:
## C57s:

