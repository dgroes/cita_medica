## C52: Búsqueda de disponibilidad, selección de horarios y resumen de cita
En este cambio se añade una mejora en la selección de horarios, añadiendo una nueva `card` la cual muestra el "resumen" de la cita, además de la selción de paciente que se logra con una conexión a una api propia.
### AppointmentManager.php
Entonces en este fichero se crea un método llamado `updated`.
- Cada vez que en el front (JS de Alpine) se cambia `selectedSchedules`, Livewire detecta el cambio y ejecuta `fillAppointment($value)`.
- Esto rellena `appointment['doctor_id'],` `start_time`, `end_time` y `duration`
- Haciendo que el bloque de **Resumen de cita** se actualice automáticamente con los cambios.
Además está la propiedad computada `doctorName()`:
- cuando `$appointment['doctor_id']` tiene un valor, busca en `$this->availabilities` y extrae el nombre del doctor.
- En blade se aplica aquí 
```php
// resources/views/livewire/admin/appointment-manager.blade.php
{{ $this->doctorName }}
```
por lo que este texto siempre estará sincronizado.
### Appointment-manager.blade.php
Aquí lo anterior aplica dentro de lo que está dentro de:
```html
{{-- Datos de la cita a agendar (resumen de cita) --}}
<div class="col-span-1">
    ...
</div>    
```
- Cuando se selecciona un horario en el listado de doctores (arriba en la página), AlpineJS modifica `selectedSchedules`.
- Esto dispara `updated()` en el componente Livewire.
- `updated()` llama a `fillAppointment()`, que actualiza el array `$appointment`.
- Al actualizarse `$appointment` o `$availabilities`, Livewire refresca la vista, y el bloque **Resumen de la cita** muestra los nuevos valores.
- `doctorName()` se vuelve a calcular cada vez que se cambian esas dependencias.
### Api.php
En `select` que está en `appointment-manager.blade.php` está lo siguiente:
```html
<x-wire-select 
    label="Paciente" 
    placeholder="Selecciona un paciente" 
    :async-data="route('api.patients.index')"
    wire:model="appointment.patient_id" 
    icon="user" 
    option-label="name"
    option-value="id" 
/>
```
Aquí lo que hace es: cargar las opciones desde la URL `/api/patients` y cuando el usuario seleccione una, guarda el `id` en `appointment.patient_id”`. El flujo sería:
1. El usuario abre la vista `appointment-manager.blade.php`.
2. Ese `<x-wire-select>` se renderiza vacío pero con la configuración de carga asíncrona (`:async-data="route('api.patients.index')"`).
3. Cuando el usuario empieza a escribir en el campo:
    - El componente `<x-wire-select>`hace una petición AJAX a `/api/patients?search=<texto>`.
    - El endpoint en `routes/api.php` ejecuta la query que me mostraste, filtrando por nombre o email, y devuelve un JSON con `{ id, name }`.cons
4.` <x-wire-select>` recibe el JSON y lo pinta en la lista desplegable.
5. El usuario selecciona un paciente → Livewire actualiza `appointment.patient_id` en el backend en tiempo real.
6. Ese `patient_id` se usará después para crear o confirmar la cita junto con el doctor, fecha y hora seleccionados.
## C53: Discriminar horarios disponibles
Para solo mostrar horarios de citas disponibles `AppointmentService.php` se creó el siguiente método:
```php
// app/Services/AppointmentService.php
public function getAvailableSchedules($schedules, $appointments)
    {
        return $schedules->map(function ($schedule) use ($appointments) {

            $isBooked = $appointments->some(function ($appointment) use ($schedule) {
                $appointmentPeriod = CarbonPeriod::create(
                    $appointment->start_time,
                    config('schedule.appointment_duration') . ' minutes',
                    $appointment->end_time
                )->excludeEndDate();

                return $appointmentPeriod->contains($schedule->start_time);
            });

            return [
                'start_time' => $schedule->start_time->format('H:i:s'),
                'disabled' => $isBooked,
            ];
        });
    }
```
Este método determina si cada horario está copudado o no, recibiendo como parametro:
- `$schedules`: Los horarios que el doctor puede trabajar según su agenda
- `$appointments`: citas ya reservadas en esos horarios.
En la sección:
```php
$isBooked = $appointments->some(function ($appointment) use ($schedule) {
    ...
}
```
- Para cada cita existente (`$appointment`), genera un rango de tiempo (`CarbonPeriod`) desde `start_time` hasta `end_time` en intervalos de duración de cita (`appointment_duration` en `config`, osea 15 mintuos)
- verifica si el horario del `schedule` está dentro de ese rango.
- Si `$isBooked = true` (ocupado).
El arreglo devolvería un arreglo similar a esto:
```json
[
    'start_time' => '10:00:00',
    'disabled' => true // si está reservado
]
```
Además para que este método funcione en `processResults` se hace el llamado para la filtración de los datos:
```php
// app/Services/AppointmentService.php
{

            $schedules = $this->getAvailableSchedules($doctor->schedules, $doctor->appointments);

            return $schedules->contains('disabled', false) ?
                [
                    $doctor->id => [
                        'doctor' => $doctor,
                        'schedules' => $schedules,
                    ]
                ] : [];
        });
```
- Aquí solo  se incluye al doctor en `$availabilities` si al menos uno de sus horarios tiene `'disabled' => false`.
- Si todos los horarios están ocupados, ese doctor ni siquiera aparecería en la vista.
Para que todo esto esté reflejado en la view, se hace una modificación aquí:
```php
// resources/views/livewire/admin/appointment-manager.blade.php
@foreach ($availability['schedules'] as $schedule)
                                        <li>
                                            <x-wire-button
                                                :disabled="$schedule['disabled']"
```
- Si `'disabled' => true`, el botón estará inactivo (no clickable)
- Esto evita que el usuario seleccione horas ya reservadas.
- Los horarios libres (`disable = false`) quedan habilitados y se pueden seleccionar.
## C54: Edición de una cita
En el caso de que se quiera cambiar el horario, día o doctor de una cita se añadiría lo siguiente:
Primero se modificará el enum de Appointment:
### Estatus de la cita y con color
```php
// app/Enums/AppointmentEnum.php
public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Programada',
            self::COMPLETED => 'Completada',
            self::CANCELLED => 'Cancelada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SCHEDULED => 'blue',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
        };
    }
```
Aquí se agrega el método `label` que devuleve un ``string``, aquí lo que se hace es transformar su nombre en mayusculas e ingles a español, entonces ahora dentro del fichero `appointments/edit.blade.php` está lo siguiente:
```php
// resources/views/admin/appointments/edit.blade.php
<div>
    <x-wire-badge
        flat
        :color="$appointment->status->color()"
        :label="$appointment->status->label()" />
</div>
```
aquí utilizando un [badge](https://wireui.dev/components/badge) de WireUI se adaptará el color utilizando dichos colores disponibles de WireUI.
### Editar cita
Para poder editar la cita previamente agendada:
```php
// app/Livewire/Admin/AppointmentManager.php
public ?Appointment $appointmentEdit = null;

 public function mount()
    {
        if ($this->appointmentEdit) {
                    $this->appointment['patient_id'] = $this->appointmentEdit->patient_id;
                }
    }

public function save()
    {
        if($this->appointmentEdit)
            {
                $this->appointmentEdit->update($this->appointment);

                $this->dispatch('swal', [
                    'icon' => 'success',
                    'title' => 'Cita actualizada correctamente',
                    'text' => 'La cita ha sido actualizada exitosamente.',
                ]);

                $this->searchAvailability(new AppointmentService());

                return;
        }
    }
```
Aquí al editar utilizando el método `save` lo que hará es luego de validar los datos pasar por un `if`. Primero, `public ?Appointment $appointmentEdit = null;` es una proieadad publica del componente, el signo `?` significa que puede ser un objeto de tipo `Appointment` o `null`, por defecto se inicializa en `null`.
Eso es clave para lo que se busca lograr, sirve para:
- **Crear una nueva cita** -> `$appointmentEdit` recibe una instancia de `Appointment`
- **Editar una cita existente** ->  `$appointmentEdit` recibe una instancia de `Appointment`.
Luego lo añadido en el método `mount()`, si `$appointment` **viene con datos (modo edición)**: inicializa el formulario (`$this->appointment`) con los datos de la cita que se está editando (en este caso el `patient_id`).

El `if` del método `save()`, es decir:
```php
public function mount()
{
    $this->specialties = Speciality::all();

    $this->search['date'] = now()->hour >= 12
        ? now()->addDay()->format('Y-m-d')
        : now()->format('Y-m-d');

    if ($this->appointmentEdit) {
        $this->appointment['patient_id'] $this->appointmentEdit->patient_id;
    }
}
```
- aquí lo que pasa en el método es siempre cargar las especialidades y setea la fecha por defecto.
- Si `$appointmentEdit` viene con datos (modo edición): inicializa el formulario (`$this->appointment`) con los datos de la cita que se está editando.
### Guardar una cita
En:
```php
public function save()
{
    $this->validate([...]);

    if($this->appointmentEdit)
    {
        $this->appointmentEdit->update($this->appointment);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Cita actualizada correctamente',
            'text' => 'La cita ha sido actualizada exitosamente.',
        ]);

        $this->searchAvailability(new AppointmentService());

        return;
    }

    Appointment::create($this->appointment);

    session()->flash('swal', [...]);

    return redirect()->route('admin.appointments.index');
}
```
Lo que pasa aquí es:
- Si `$appointmentEdit` **no es null** significa que se está editando una cita.
    - Entonces se hace un `$this->appointment->update($this->appointment)`
    - se muestra un SweetAlert de éxito
    - Se vuelve a buscar disponibilidad para refrescar la info
- Si `$appointmentEdit` **es null** significa que es una nueva cita.
    - se hace un `Appointment::create(...)`
    - Se redirige al listado de citas.
## C55: Consultation
Se crea el model y migration de **Consultation**:
```bash
❯ php artisan make:model Consultation -m

   INFO  Model [app/Models/Consultation.php] created successfully.  

   INFO  Migration [database/migrations/2025_08_26_212314_create_consultations_table.php] created successfully.  
```
Añadiendo los campos correspondientes a la migración. Luego sería el agregado de las relaciónes en el modelo. Dentro del modelo estará el casteo de `prescription` que será tipo `json`.
Ahora, consultatión serán las consultas de una cita, entonces además de la relación entre modelos que debe haber, además dentro de `AppointmentManager.php` se añadirá esto:
```php
Appointment::create($this->appointment)
            ->consultation()
            ->create([]);
```
haciendo que al crear la cita, se cree además una consulta.
## C56: Consultation(2)
### Lo principal
Siguiendo con las consulta médica que se realizo en base a una cita médica, está la nueva view: `resources/views/admin/appointments/consultation.blade.php`. Además de su método en el controller de Appointment:
```php
// app/Http/Controllers/Admin/AppointmentController.php
public function consultation(Appointment $appointment){
        return view('admin.appointments.consultation', compact('appointment'));
    }
``` 
Luego está un componente de Livewire para las consultas:
```bash
❯ php artisan make:livewire Admin/ConsultationManager
 COMPONENT CREATED  🤙

CLASS: app/Livewire/Admin/ConsultationManager.php
VIEW:  resources/views/livewire/admin/consultation-manager.blade.php
```
Creando así la clase y su componente. Luego dicho componente se llamaría al fichero `consultation.blade.php`en un inicio veindose así:
```php
// resources/views/admin/appointments/consultation.blade.php
<x-admin-layout title="Citas | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],
    [
        'name' => 'Consulta',
    ],
]">

    @livewire('admin.consultation-manager', ['appointment' => $appointment])

</x-admin-layout>
s
```
### El componente Livewire
Luego de crear los el componente Livewire estará el fichero `admin/consultation-manager.blade.php` el cual será similar `card` realizada en `admin/patients/edit.blade.php`. En un inicio el fichero sería:
```php
// resources/views/livewire/admin/consultation-manager.blade.php
<div>
    <x-wire-card class="mb-2">
        <div class="lg:flex lg:justify-between lg:items-center">
            <div class="flex items-center space-x-5">
                <img src="{{ $appointment->patient->user->profile_photo_url }}" alt="{{ $appointment->patient->user->name }}">
                // AQUÍ IRÍA EL RESTO DE CÓDIGO...
        </div>
    </x-wire-card>
</div>
```
Aquí se puede ver el cambio a diferencía del fichero de edición de patients, se le agregaría primero `$appointment`, el cual lo sacaría del fichero `appointments/consultation.blade.php`:
```php
// resources/views/admin/appointments/consultation.blade.php
<x-admin-layout title="Citas | CitasMédicas">

    @livewire('admin.consultation-manager', ['appointment' => $appointment])

</x-admin-layout>
```
Esa varíable con el contenido de la consulta pasaría por esa view, pero se consigue en un inicio en el controller de Appointment:
```php
// app/Http/Controllers/Admin/AppointmentController.php
public function consultation(Appointment $appointment){
        return view('admin.appointments.consultation', compact('appointment'));
    }
```
Y en la vista `consultation-manager` si realizara un `dd()` sacaría esto:
```json
App\Models\Appointment {#2910 ▼ // resources/views/livewire/admin/consultation-manager.blade.php
  #connection: "mysql"
  #table: "appointments"
  #primaryKey: "id"
  #keyType: "int"
  +incrementing: true
  #with: []
  #withCount: []
  +preventsLazyLoading: false
  #perPage: 15
  +exists: true
  +wasRecentlyCreated: false
  #escapeWhenCastingToString: false
  #attributes: array:11 [▼
    "id" => 1
    "patient_id" => 8
    "doctor_id" => 1
    "date" => "2025-08-28"
    "start_time" => "08:00:00"
    "end_time" => "08:15:00"
    "duration" => 15
    "reason" => "Dolor en el cuello, ocasionando la percepción de que le falta su cabeza   "
    "status" => 1
    "created_at" => "2025-08-26 21:44:50"
    "updated_at" => "2025-08-26 21:44:50"
  ]
//  ... <-Aquí más datos
}
```
Sacando todos los datos importantes de la consulta médica del paciente
### El controlador del componente:
Dentro del fichero `ConsultationManager.php` estaría el manejo general de una consulta, el guardado de la consulta, la actualización de los datos de carga, entre otras cosas.
## C57: Spinner de carga
Al añadir un nuevo medicamento en el formulario de "Consulta" en la `tab` de "Receta", están los campos para registrar un medicamentos y el botón de "Añadir Medicamento". Dicho botón tiene estas propiedades:
```php
// resources/views/livewire/admin/consultation-manager.blade.php
<div class="mt-4">
    <x-wire-button outline secondary
        wire:click="addPrescription"
        spinner="addPrescription">
        <i class="fa-solid fa-plus mr-2"></i>
        Añadir medicamento
    </x-wire-button>
</div>
```
Con `wire:click` se activa el método `addPrescription()` el cual está vinculado con `ConsultationManager.php`. En este caso dicho método sería:
```php
// app/Livewire/Admin/ConsultationManager.php
public function addPrescription()
    {
        $this->form['prescriptions'][] = [
            'medicine' => '',
            'dosage' => '',
            'frequency' => '',
        ];
    }
```
Etonces además de agregar un nuevo formulario de `prescriptions` en formato de un nuevo array, con spinner se le agrega dinamismo. Con Alpine hay en ocaciones pequeños retrasos en la carga dinamica de algunos componentes. **con `spinner` dentro de un `x-button` de WireUI se añade un spinner de carga antes de que se carge el nuevo elemento en el DOM.**. En este caso se hace el `spinner` cuando se accede al método `addPrescription` del controller de consultas.
## C58: Buscar todas las consultas
Dentro de una consulta están lo botontes de "Ver Historial" y "Consultas Anteriores", este último enseña las consultas previas que ha tenido un paciente. Pero ahora dentro de ese modal se añadió el botón de "Ver todas las consultas en detalle". Dentro de modal, en la plantilla blade está esto:
```php
// resources/views/livewire/admin/consultation-manager.blade.php
<x-wire-button
    href="{{ route('admin.appointments.index', ['namePatient' => $consultation->appointment->patient->user->name]) }}"
>
```
Al hacer clic al botón lo que se envia sería algo así: `/admin/appointments?namePatient=Eddard+Stark`.
Entonces el index (`resources/views/admin/appointments/index.blade.php`) es el que recibe la patición y el que se encarga de mostrar la tabla de citas. En este punto el parámetro (`namePatient`) ya está en la request, por lo se puede acceder a él con `request('namePatient')`. Aquí luego está esto:
```php
// resources/views/admin/appointments/index.blade.php
@livewire('admin.datatables.appointment-table', [
    'namePatient' => request('namePatient') ?? null
])
```
En ese código se le pasa la variable al componente Livewire que genera la tabla.
Ya dentro del componente de la tabla `AppointmentTable` está la propiedad pública:
```php
// app/Livewire/Admin/Datatables/AppointmentTable.php
public ?string $namePatient = null;
```
- Cuando Livewire monta el componente, recibe el valor que se le manda desde el `@livewire(...)`.
- Entonces, `$this->namePatient` queda igual a `"Eddard Stark"`.
Para usar el valor en la tabla se crea el método `mount()` aquí se verifica si existe un nombre de paciente y se usa para setear el buscador de la tabla:
```php
// app/Livewire/Admin/Datatables/AppointmentTable.php
public function mount($namePatient = null): void
{
    $this->namePatient = $namePatient;

    if ($this->namePatient) {
        $this->setSearch($this->namePatient);
    }
}
```
Con esto, cuando se carge la tabla, el input de búsqueda ya tendrá escrito el nombre `"Eddard Stark"` y la tabla estará filtrada automáticamente.
## C59: Calendario
### Inicio
Para la creación, primero se crea el controller:
```bash
❯ php artisan make:controller Admin/CalendarController
INFO  Controller [app/Http/Controllers/Admin/CalendarController.php] created successfully.  
```
Dentro del controller deberá estar los métodos:
```php
public function index(){
        return view('admin.calendar.index');
    }
```
Lo siguiente sería crear la ruta para el calendario:
```php
// routes/admin.php
Route::get('caledar', [CalendarController::class, 'index'])->name('calendar.index');
```
Luego falta agregar en el sidebar su respectiva ruta.
### FullCalendar
Para poder trabajar de manera más facil con un calendario se optó por el uso de [FullCalendar](https://fullcalendar.io/). **FullCalendar** es una biblioteca JS que permite crear calendarios interactivos y dinámicos para mostrar eventos en sitios web y aplicaciones. Proporcionando una interfaz intuitiva para agendar, editar y ver eventos en diferentes formatos.
FullCalendar se puede descargar de manera manual, utilizar un CDN o se puede instalar con NPM.
Dentro de `calendar/index.blade.php` está lo siguiente:
```php
// resources/views/admin/calendar/index.blade.php
<div x-data="data()">
        <div x-ref='calendar'></div>
</div>

@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>

    <script>
        function data() {
            return {};
        }
    </script>
@endpush
```
- `x-data="data()`
    - Alpine.js necesita un objeto para inicializar un *componente reactivo*
    - `x-data` recibe un objeto o una función que retorna un objeto.
    - En este caso:
    - ```php
        function data() {
            return {};
        }
        ```
    - Esto quiere decir que el componente Alpine se inicializa con un estado vacío (**por ahora**)
    - Ese `div` padre ya es un componente Alpine, pero sin propiedades ni métodos definidos.
- `x-ref="calendar`
    - `x-ref`sir como una referencia interna dentro del componente Alpine
    - Es como un `id` pero solo accesible desde Alpine
    - Desde dentro del componente se puede acceder a ese elemento con `this.$refs.calendar`
    - En este caso, ese `div x-ref="calendar"` será el contenedor donde se monta el calendario de FullCalendar.
Dentro de `init`:
```js
function data() {
    return {
        init() {}
        }
    }
```
Estará la configuración del calendario, como lo son las traducciones, que tipo de visualización de fechas mostrar, las horas a manejar, etc. Al ser un `init()` esto cargará automaticamente cuando se llame a la función  `data()`. 
### Creación de eventos (API)
Hora sigue la creación de una API, dentro de `routes/api.php` estará lo siguiente:
```php
// routes/api.php
Route::get('/appointments', function (Request $request) {})->name('api.appointments.index');
```
Aquí además se define su nombre: `api.appointments.index`. Entonces para llamar a dicha API desde el FullCalendar que está en `admin/calendar/index.blade.php`. Dentro del `init()` debería estar su llamado, así:
```js
function data() {
    return {
        init() {
            events: {
                    url: '{{ route('api.appointments.index') }}',
                    failure: function() {
                        alert('Error al cargar las citas');
                        console.warn('Error al cargar los eventos');
                    },
                },
        }
        }
    }
```
De momento el `events` estaría así. En `url` se especifica el nombre de la ruta a llamar, aquí sería la ruta creada en `routes/`, en este caso: `routes/api.php`, pero al crear la ruta con un alías, se usaraá ese alías para llamarlo, es decir: `api.appointments.index`.
Seguido de esto estaría una alerta al cargar la página tanto para el usuario como para un dev en la consula de comandos del navegador.
Que debería devolver la ruta?. Dentro de la ruta podría estar lo siguiente:
```php
// routes/api.php
$appointments = Appointment::with(['patient.user', 'doctor.user'])
    ->get();
return $appointments;
```
Aquí se llama al modelo `Appointments`, y con las relaciones ya definidas dentro de dicho modelo, se hace una consulta a `patient` y `doctor`. Ahora si llamo a la ruta de al api (`http://127.0.0.1:8000/api/appointments`), se muestra lo siguiente:
```js
[
  {
    "id": 1,
    "patient_id": 8,
    "doctor_id": 1,
    "date": "2025-08-28T04:00:00.000000Z",
    "start_time": "2025-09-04T12:00:00.000000Z",
    "end_time": "2025-09-04T12:15:00.000000Z",
    "duration": 15,
    "reason": "Dolor en el cuello, ocasionando la percepción de que le falta su cabeza   ",
    "status": 2,
    "created_at": "2025-08-27T01:44:50.000000Z",
    "updated_at": "2025-08-29T04:36:22.000000Z",
    "patient": {
      "id": 8,
      "user_id": 17,
      "blood_type_id": 7,
      "created_at": "2025-08-27T01:39:02.000000Z",
      "updated_at": "2025-08-27T01:39:02.000000Z",
      "allergies": null,
      "chronic_conditions": "Dolor crónico cervical (producto de tortura)",
      "surgical_history": "Antigua fractura de pierna curada",
      "family_history": "Padre falleció de fiebre del pantano",
      "observations": "Paciente con historial de encarcelamiento y decapitación no completada",
      "emergency_contact_name": "Catelyn Stark",
      "emergency_contact_relationship": "Esposa",
      "emergency_contact_phone": "56999887766",
      "date_of_birth": "1960-02-15",
      "photo": null,
      "user": {
        "id": 17,
        "name": "Eddard Stark",
        "email": "ned.stark@gmail.com",
        "email_verified_at": "2025-08-27T01:39:01.000000Z",
        "two_factor_confirmed_at": null,
        "dni": "14326789-2",
        "phone": "56970011223",
        "address": "Invernalia, Norte, Poniente",
        "current_team_id": null,
        "profile_photo_path": null,
        "created_at": "2025-08-27T01:39:02.000000Z",
        "updated_at": "2025-08-27T01:39:02.000000Z",
        "profile_photo_url": "https://ui-avatars.com/api/?name=E+S&color=7F9CF5&background=EBF4FF"
      }
    },
    "doctor": {
      "id": 1,
      "user_id": 1,
      "speciality_id": 1,
      "medical_license_number": "MED123456",
      "biography": "Dr. Clegane es un cardiólogo con más de 10 años de experiencia en el tratamiento de enfermedades del corazón.",
      "is_active": 1,
      "created_at": "2025-08-27T01:39:02.000000Z",
      "updated_at": "2025-08-27T01:39:02.000000Z",
      "user": {
        "id": 1,
        "name": "Sandor Clegane",
        "email": "sandor@gmail.com",
        "email_verified_at": "2025-08-27T01:39:01.000000Z",
        "two_factor_confirmed_at": null,
        "dni": "14563210-k",
        "phone": "56970234712",
        "address": "Tierras del Oeste, Poniente",
        "current_team_id": null,
        "profile_photo_path": null,
        "created_at": "2025-08-27T01:39:01.000000Z",
        "updated_at": "2025-08-27T01:39:01.000000Z",
        "profile_photo_url": "https://ui-avatars.com/api/?name=S+C&color=7F9CF5&background=EBF4FF"
      }
    }
  },
]
```
Aquí la API trae las distintas citas programadas
>Este sería un ejemplo de lo que hace, obviamente esto estará sujeto a cambios proximos, añadiendo más complejidad.
En FullCalendar hay tipos de valor que debería recibir y que se deberían transformar para poder trabajaro con dichos datos. 
Primero, los colores, observar el siguiente código:
```php
// routes/api.php
return $appointments->map(function(Appointment $appointment){
        return [
            'id' => $appointment->id,
            'title' => $appointment->patient->user->name,
            'start' => $appointment->start->toIso8601String(),
            'end' => $appointment->end->toIso8601String(),
            'color' => $appointment->status->colorHex(),
            'extendedProps' => [
            ]
        ];
    })->values();
```
Aquí está en `color` el llamado a `$appointment`, es decir a: `app/Models/Appointment.php` y se accese a `status`, el cual en el modelo hace un llamado a `app/Enums/AppointmentEnum.php` el cual tiene esto:
```php
// app/Enums/AppointmentEnum.php
 public function colorHex(): string
    {
        return match ($this) {
            self::SCHEDULED => '#3490dc', // Azul
            self::COMPLETED => '#38c172', // Verde
            self::CANCELLED => '#e3342f', // Rojo
        };
    }
```
Aquí se crea el método `colorHex()`, que devuele un color en especifico en base a si la cita es `SCHEDULED, COMPLETED o CANCELLED `, en base a un color exadecimal, formato que FullCalendar soporta, por ejemplo, en el mismo fichero de Enum está el método `color()`, el cual devuelve colores escritos de manera normal en ingles, estos solo fucnionan con Tailwind, para FullCalendar se necesitan los colores en formato exadecimal.

Siguiendo con la transformación de datos, está `'start'` y `'end'`. Dichos valores son arrojados en un formato no utilizado por FullCalendar. Para cambiar eso nuevamente en el modelo de Appointment se crean los **accesores** `end` y `start`. 
### Accesores
Un accesor es un método que se ejecuta **cuando se lee un atributo del modelo**. Es decir, en vez de devolver directamente el valor que está en la base de datos, te permite transformarlo antes de entregarlo.
FullCalendar no maneja y trata los datos de fecha como lo hace Laravel, por lo que se necestia transformar los valores antes de pasarlos al FullCalendar. Creando así estos 2 accesores:
```php
// app/Models/Appointment.php
class Appointment extends Model
{
    public function start(): Attribute
        {
            return Attribute::make(
                get: function () {
                    $date = $this->date->format('Y-m-d');
                    $time = $this->start_time->format('H:i:s');

                    return Carbon::parse("{$date} {$time}");
                }
            );
    }

    public function end(): Attribute
        {
            return Attribute::make(
                get: function () {
                    $date = $this->date->format('Y-m-d');
                    $time = $this->end_time->format('H:i:s');

                    return Carbon::parse("{$date} {$time}");
                }
            );
    }
}
```
Etonces en dichos **accesores** lo que se hace es contruir un objeto `Carbon` (fecha+hora completa) al momento de acceder a `$appointment->start` y `$appointment->end` en la API:
- `$appointment->start` no devuelve el valor "tal cual" se guardo en la BD
- Devuelve un objeto `Carbon` ya combinado, para que luego se pueda hacer lo del código de `routes/api.php`:
```js
// routes/api.php
'start' => $appointment->start->toIso8601String(),
'end' => $appointment->end->toIso8601String(),
```
Y ahora, `toIso8601String()` es un método **Carbon** el cual convierte la fecha a un string con formato **ISO 8601**, que es el estándar que espera FullCalendar, sería algo como: `"2025-09-04T11:00:00-04:00"`.
## C60: Modal de calendario
### API
Dentro de la API se añadira esta nueva parte de código:
```php
'extendedProps' => [
                // C60: Modal de calendario
                // Envio de información adicional de la cita, pea su uso en el modal
                'dateTime'  => $appointment->start->format('d/m/Y H:i:s'),
                'patient'   => $appointment->patient->user->name,
                'doctor'    => $appointment->doctor->user->name,
                'status'    => $appointment->status->label(),
                'color'     => $appointment->status->color(),
                'url'       => route('admin.appointments.consultation', $appointment),
            ]
```
Estos serán los datos a enviar a la vista, la fecha, paciente, doctor, status, color y url. Esta última, la url tiene la dirección de la "gestión de consulta" del paciente.
### View
Para el uso de un modal dentro del calendario, se hace uso de WireUI nuevamente, con su modal. Entonces dentro de `admin/calendar/index` está lo siguiente:
**Estilos a FullCallendar**
```php
@push('css')
    <style>
        .fc-event {
            cursor: pointer;
        }
    </style>
@endpush
```
Primero se le agrega un estio al calendar, mes en concreto al botón el cual muestra la cita en el calendario. Aquí se le agrega el estilo de `pointer` al cursor cuando pasa por encima del botón.
**Redirección**
Además de lo básico a mostrar dentro del modal, está al final el botón de redirección. Este botón redirige a `selectedEvent.url`. Dicha ruta fue especificada en la API. Entonces mandará al usuario a la gestión de la cita. **Esta acción estaría pensada para el uso del Doctor**.
## C61: Roles y permisos
Para la asignación de permisos dentro del sistema, se opta por no tener una gestión de permisos para un perfil adminstrador, en su lugar **se realizará la asignación de permisos por medio de las `seeders`**.
```bash
❯ php artisan make:seeder PermissionSeeder

   INFO  Seeder [database/seeders/PermissionSeeder.php] created successfully.  
```
En el sistema hay distintos modulos, por ejemplo, visualizar el dashboard, roles y permisos, usuarios, pacientes, doctores, citas médicas, etc.
Para poder tener acceso a dichas partes del sistema, se le asignaran dichos permisos a los distintos roles que hay. Para esto dentro del seeder deberá estar lo siguiente:
```php
// database/seeders/PermissionSeeder.php
public function run(): void
    {
        $permissions = [
            'access_dashboard',

            'create_role',
            'read_role',
            'update_role',
            'delete_role',

            'create_user',
            'read_user',
            'update_user',
            'delete_user',

            'read_paciente',
            'update_paciente',

            'read_doctor',
            'update_doctor',
            
            'create_appointment',
            'read_appointment',
            'update_appointment',
            'delete_appointment',

            'read_calendar',
        ];
    }
```
Aquí están separados por partes, esto está relacionado con el sidebar. Dentro de `layouts/includes/admin/sidebar` hay un array de `$links`, el cual muestra las distintas partes del sistema. Dichas partes son las que se hablan aquí en el Seeder.
Ahora una modificación al seeder `RoleSeeder`.
```php
$roles = [
    'Paciente' => [
        'access_dashboard',
        'create_appointment',
        'read_appointment',
        'read_calendar',
    ],

    'Doctor' => [
        'access_dashboard',
        'read_appointment',
        'update_appointment',
        'delete_appointment',
        'read_calendar',
    ],

    'Recepcionista' => [
        'access_dashboard',

        'create_user',
        'read_user',
        'update_user',
        'delete_user',

        'read_paciente',
        'update_paciente',

        'read_doctor',
        'update_doctor',

        'create_appointment',
        'read_appointment',
        'update_appointment',
        'delete_appointment',

        'read_calendar',

    ],
]
```
Aquí demás de la creación de 3 roles del sistema (paciente, doctor y recepcionista) a cada rol se le añade un array con el nombre de los "permisos creados". Luego bastará con 
```php
foreach ($roles as $role => $permissions) {
    Role::create([
        'name' => $role
    ])
    ->givePermissionTo($permissions);
}


Role::create([
    'name'=> 'Admin',
])->givePermissionTo(Permission::all());
``` 
En el bucle lo que pasa el lo siuiente:
- Hay un array de `$roles` donde la **clave** es el nombre del rol (ej:`"Paciente"`, `"Doctor"`, `"Recepcionista"`) y el **valor** es un array de permisos (ej: `['access_dashboard', 'create_appointment', ...]`).
```php
$roles = [
    'Paciente' => ['access_dashboard', 'create_appointment', ...],
    'Doctor' => ['access_dashboard', 'read_appointment', ...],
];
```
- El `foreach` recorre ese array:
    - `$role` -> contiente el nombre del rol (ej: `"Paciente"`).
    - `$permissions` -> contiente la lista de permisos que le corresponden a ese rol.
```php
Role::create([
    'name' => $role
])
->givePermissionTo($permissions);
```
- `Role::create(['name' => $role])` crea un nuevo rol en la BD con ese nombre.
- `->givePermissionTo($permissions)` inmediatamente le asigna los perisos definidos en el array `$permissions`.
Ejemplo: Se crea rol `"Doctor"` y Automáticamente se le asignan permisos como `"read_appointment"`, `"update_appointment"`, etc.
Luego aquí:
```php
Role::create([
    'name'=> 'Admin',
])->givePermissionTo(Permission::all());
```
- Se crea un rol llamado `"Admin"`
- En vez de pasarle un array de permisos como antes, se le da directamente `Permission::all()` que devuele **todos los permisos registrados en la tabla**
- resultado: el rol `"Admin"` tiene **acceso total** a todo lo que exista
## C62: Restricción de rutas
Antes de seguir, crear el controller de Dashboard:
```bash
❯ php artisan make:controller Admin/DashboardController

   INFO  Controller [app/Http/Controllers/Admin/DashboardController.php] created successfully.  

```
Dentro del  `DashboardController` dentro del método index está lo siguiente:
```php
public function index()
    {
        Gate::authorize('access_dashboard');
        return view('admin.dashboard');
    }
```
Aquí se utiliza  `Gate` el cual forma parte del **sistema de autorización** que Laravel incluye de serie (antes incluso de usar paquetes como *spatie/laravel-permission*). Se usa para definir y verificar **políticas de acceso** (permissions simples) a ciertas acciones.
Entonces en esta linea: ` Gate::authorize('access_dashboard')` pasa:
1. Verificar si el **usuario autenticado** tiene el permiso/capacidad `acces_dashoard`.
2. Si **sí lo tiente**, la ejecución continúa y se muestra la vista.
3. Si **no lo tiene**, Laravel lanza automáticamente un `AuthorizationException`, que normalmente devuelve un HTTP 403 (Forbiden). (en mi caso: "403
Esta acción no está autorizada.").
Entonces lo que hace es **proteger la ruta** para que solo entren usuarios con ese permiso
### Relación con spatie/laravel-permission:
Aunque `Gate` es nativo de Laravel, cuando instalas el paquete de **Spatie** y configuras los permisos, este se **integra automáticamente con Gate**.
- Si un usuario tiene el permiso `"access_dashboard"` (gracias al rol asignado vía Spatie), entonces:
```php
Gate::allows('access_dashboard'); // true
```
Funciona correctamente. Esto pasa porque Spatie hace un **hook** al sistema de autorización de Laravel y define cómo resolver esos permisos.
### Cambio en Seed
Para el desarrollo será comodo tener un user `Admin` por defecto, en este caso en `UserSeeder`. Dentro del foreach de asignación de roles está lo siguiente:
```php
// database/seeders/UserSeeder.php
if ($user->email === 'davos@gmail.com') {
    $user->assignRole('Admin');
    continue;
}

if ($index < 9) {
    $user->assignRole('Doctor');
} else {
    $user->assignRole('Paciente');
}
```
Entonces primero se crea el `Admin` que será `Davos Seaworth` y luego pasará la creación de doctores y pacientes.
## C63: Refacorizar Sidebar
### Explicación de Composite
Mäs info en [Refactoring Guru](https://refactoring.guru/es/design-patterns/composite)
Para mejorar el actual comportamiento del sidebar (`views/layouts/includes/admin/sidebar`). Se opta por un cambio el cual mejora su comportamiento actual el cual ya posee muchas condicionales. Es el uso de Composite.
**Composite** es un patron estrucural de diseño que se usa cuando se tienen **objetos individuales** y **composiciones de objetos** que deben ser tratados de **manera uniforme**. En otras palabras, permite estrucurar objetos en forma de árbol (jerarquía) donde una hoja y un grupo de hojas se manipulan igual.
### 1. config/sidebar.php
Aquí se definen los datos crudos del sidebar (tipo de ítem, ruta, titulo, icono, permisos, etc.):
```php
// config/sidebar.php
return [
    [
        'type' => 'header',
        'title' => 'Gestión',
    ],
    [
        'type' => 'link',
        'title' => 'Dashboard',
        'icon' => 'fa-solid fa-chart-pie',
        'route' => 'admin.dashboard',
        'active' => 'admin.dashboard',
        'can' => ['access_dashboard'],
    ],
];
```
Este "array" previamente estaba en fichero `resources/views/layouts/includes/admin/sidebar.blade.php`, pero se traslado aquí para mantener la lógica separada e integrarlo con los ficheros posteriores.
### 2. SidebarComposer
Este fichero recibe ese `config` y lo transforma en **objetos** (`ItemHeader`, `ItemLink`, `ItemGroup`).
Gracias al `View::composer('layouts.admin', SidebarComposer::class)` en `AppServiceProvider`, cada vez que se carga `layouts.admin`, se inyecta la variable `$sidebarItems`. Esa variable ya contiene los objetos listos para renderizarse.
### 3. ServiceProvider
Laravel tiene un ciclo de vida donde en el método `boot()` de los **service providers** se registran cosas que deben ejecutarse cuando la app arranca.  Aquí en el fichero está esto:
```php
// app/Providers/AppServiceProvider.php
public function boot(): void
    {
        View::composer('layouts.admin', SidebarComposer::class);
    }
```
Esto significa que "Cada vez que la vista `layouts.admin` se vaya a renderizar, Laravel va a llamar a la clase `SidebarComposer` y le va a pasar el objeto `View` para que pueda inyectarse datos."
El flujo con el `SidebarComposer` sería el siguiente:
1. El usuario entra a una página que hereda de `layouts.admin`
2. Laravel ve que esa vista tiene una **view composer** registrado
3. Ejecuta el método `composer(View $view)` de `SidebarComposer`
4. El composer construye los objetos `ItemHeader`, `ItemLink`, `ItemGroup` a partir de `config/sidebar.php`
5. Inyecta la colección en la vista con:
```php
// app/View/Composers/SidebarComposer.php
$view->with('sidebarItems', $items);
```
6. Ahora, en `resources/views/layouts/includes/admin/sidebar.blade.php`, se puede hacer:
```php
// resources/views/layouts/includes/admin/sidebar.blade.php
 @foreach ($sidebarItems as $item)
    <li>
        {!!  $item->render()!!}
    </li>
@endforeach
```
El resultado sería que gracias a ese composer registrado en el provider, cada vez que se abre el layout de administración, el sidebar ya viene armado con sus items listos para renderizar. Òsea `AppServiceProviders` es el **punto de entrada** que conecta al sidebar dinámico con el ciclo de vida de Laravel.
### 4. Clases ítems
En `ItemHeader`, `ItemGroup` e `ItemLink` pasa:
- En todas se implementan la interfaz `ItemSidebar`.
- Cada clase sabe cómo renderizarse `render()` y cúando mostrarse (`authorize()`)
- Esto encapsula la lógica:
    - `ItemHeader` -> imprime solo un texto decorativo
    - `ItemLink` -> imprime un enlace con icono y verificación de permisos.
    - `ItemGroup` -> agrupa links, renderiza solo los autorizados y delega a una view Blade `sidebar.item-group`.
### 5. View sidebar.blade.php
Rebice el `$sidebarItems` del composer y Renderiza cada ítem con: 
```php
@foreach ($sidebarItems as $item)
    <li>
        {!!  $item->render()!!}

    </li>
@endforeach
```
### 6. Patron Composite
Aquí se tiene una jerarquía de objetos (`ItemGroup` puede contener varios `ItemLink` o incluso más grupos). Todos implementan la misma interfaz `ItemSidebar` y se puede tratarlos de forma uniforme (`$item->render()`, `item->authorize()`).
### 7.  SidebarComposer Mäs en detalle
Primerto está el método `compose`
```php
// app/View/Composers/SidebarComposer.php
public function compose(View $view) 
{
    // 1. Obtiene el arreglo definido en config/sidebar.php
    $items = collect(config('sidebar'))
        ->map(function ($item) {
            // 2. A cada item del config, lo transforma en un objeto (ItemLink, ItemHeader, ItemGroup)
            return $this->parseItem($item);
        });

    // 3. Inyecta esa colección en la vista como $sidebarItems
    $view->with('sidebarItems', $items);
}
```
1. **Lee el archivo `config/sidebar.php`**:
Este archivo tiene un array con elementos que describen el menú (tipo, título, icono, permisos, rutas, etc.)
2. **Transforma cada elemento en un objeto de el dominoi (OO)**: 
En ves de trabajar con arrays planos en la vista, pasa cada ítem al método `parseItem()`. Este método devuelve instancias de clase (`ItemLink`, `ItemHeader` e `ItemGroup`), todas implementando la interfaz `ItemSidebar`.
3. **Entrega la colección a la vista**:
`$view->with('sidebarItems', $items)` hace que en la Blade `layouts.admin` se tenga disponible una variable `$sidebarItems` que ya es una lista de objetos listos para `render()`. Y como la view `includes/admin/sidebar.blade.php` hereda de `layouts.admin`, es debido a eso que dentro del sidebar se puede utilizar dicha variable `$sidebarItems`.
La idea clave del método es actuar como traductor entre configuración (datos planos) y objetos listos para pintar.

Luego está el método `parseItem`
```php
// app/View/Composers/SidebarComposer.php
public function parseItem($item)
{
    switch ($item['type']) {
        case 'header':
            return new ItemHeader(
                title: $item['title'],
                can: $item['can'] ?? []
            );
            break;

        case 'link':
            return new ItemLink(
                title: $item['title'],
                icon: $item['icon'] ?? 'fa-regular fa-circle',
                href: $item['route'] ? route($item['route']) : '#',
                active: $item['active'] ? request()->routeIs($item['active']) : false,
                can: $item['can'] ?? []
            );
            break;

        case 'group':
            $group = new ItemGroup(
                title: $item['title'],
                icon: $item['icon'] ?? 'fa-regular fa-folder',
                active: $item['active'] ? request()->routeIs($item['active']) : false
            );

            foreach ($item['items'] as $subItem) {
                // recursividad: cada subitem puede ser link o header, etc.
                $group->add($this->parseItem($subItem));
            }

            return $group;
            break;

        default:
            throw new \InvalidArgumentException("Unknown sidebar item type: {$item['type']}");
            break;
    }
}
```
1. **Aquí se evalúa el tipo de ítem(`header`, `link`, `group`)**
    - **Header**: solo renderiza un título/separador en el menú
    - **Link**: crea un enlace con ícono, título y verificación si la ruta actual está activa (`request()->routeIs`).
    - **Group**: Es un contenedor de subitems (ej: "Gestión" con `Usuarios`, `Roles`, etc)
        - Aquí hay **recursividad**: cada subitem vuelve a pasar por  `parseItem()`. ESto permite que un grupo pueda contener más grupos, y así sucesivamente.
2. **Crea una instancia de la clase correspondiente**
    - Así cada tipo tiene su propio método `render()` y `authorize()`
3. **Devuelve el objeto creado**
    - `perseItem()` es un **factory method**: según el `type` decide qué clase instanciar.
### 8. ItemGroup más en detalle
En `ItemGroup::render()` hay esto:
```php
// app/Services/Sidebar/ItemGroup.php
public function render(): string
{
    $items = array_filter($this->items, function ($item) {
        return $item->authorize();
    });

    return view('sidebar.item-group', [
        'title' => $this->title,
        'icon' => $this->icon,
        'active' => $this->active,
        'items' => $items,
    ])->render();
}
```
1. **filtra subitems**:
    - `$this->items` contiene los subítems agregados con `add()`.
    - Usa `authorize()` para decidir si un ítem debe mostrarse o no (por ejemplo, permisos con Gates/Polices).
2. **Renderiza una view parcial**:
    - Llama a `view('sidebar.item-group', [...])->render()`
    - Esto carga la blade `resources/views/sidebar/item-group.blade.php`, le pasa las variables y obtiene como resultado HTML listo pra insertarse en el sidebar.
3. **Dentro de la view `sidebar/item-group.blade.php` está lo siguiente**
```php
// resources/views/sidebar/item-group.blade.php
<div x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button type="button"
        class="flex items-center w-full p-2 ..."
        @click="open = !open">
        
        <span class="size-6 inline-flex justify-center items-center">
            <i class="{{ $icon }}"></i>
        </span>

        <span class="flex-1 ms-3 text-left">{{ $title }}</span>

        <i :class="{
            'fa-solid fa-chevron-up': open,
            'fa-solid fa-chevron-down': !open
        }"></i>
    </button>

    <ul x-show="open" x-cloak class="py-2 space-y-2">
        @foreach ($items as $item)
            <li class="pl-4">
                {!! $item->render() !!}
            </li>
        @endforeach
    </ul>
</div>
```
1. `x-data="{ open: true|false }"`
    - Alpine.js inicializa un estado local `open`.
    - si `$active` viene en `true` (la ruta actual coincide con el grupo) el menú se muestra abierto por defecto.
2. `button`
    - Buestra el título del grupo + ícono.
    - `@click="open = !open` cambia el valor de `open`, alternando abierto/cerrado.
3. El ícono de flecha `<i>`
    - Usa `:class` para alternar dinámicamente el ícono según el estado de `open`.
    - Si está abierto -> `fa-chevron-up`. si está cerrado -> `fa-chevron-down`
4. El `<ul>` con subítems
    - `x-show="open"`: solo se muestra si `open` es `true`
    - `x-cloak`: evita que se vea antes de que alpinejs inicialice
    - itera `$items` y llama a su `render()`, que puede ser un `ItemLink` o incluso otro grupo.
5. **Resumen**
- Permite tener menús colapsables dentro del sidebar.
- Los grupos pueden contener varios enlaces relacionados.
- Gracias a Alpine.js, todo funciona en el frontend sin necesidad de recargar la página.
- Gracias al Composite Pattern, un grupo puede contener otros grupos o enlaces, y todos saben cómo renderizarse a sí mismos.
6. **Flujo completo**
1. `config/sidebar.php` → define un ítem de tipo `group`.
2. `SidebarComposer::parseItem()` -> crea un `ItemGroup`.
3. `ItemGroup::add()` -> le mete subitems (`ItemLink`, `ItemHeader`, etc.).
4. `ItemGroup::render()` → carga la Blade `sidebar/item-group.blade.ph`.
5. En la Blade, Alpine.js controla abrir/cerrar el grupo dinámicamente.

