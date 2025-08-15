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
## C53: Discriminar fechas repetidas
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
## C54:
## C55:
## C56:
## C57:
