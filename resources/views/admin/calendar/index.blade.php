<x-admin-layout title="Citas | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Calendario',
    ],
]">
    {{-- C59: Calendario --}}
    {{-- Inicializar Alpine --}}
    <div x-data="data()">
        <div x-ref='calendar'></div>
    </div>

    @push('js')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>

        <script>
            function data() {
                return {
                    // Inicializar el calendario si bien es cargado el componente, por ejemplo, prueba hacer un alert
                    init() {
                        //Alert de prueba
                        // alert("Hola, el componente se ha cargado");

                        // Inicializar el calendario
                        var calendarEl = this.$refs.calendar;

                        // Crear el calendario
                        var calendar = new FullCalendar.Calendar(calendarEl, {

                            // Configuración Header del calendario
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                            },

                            // Idioma del Callendar
                            locale: 'es',

                            // Traducir botones
                            buttonText: {
                                today: 'Hoy',
                                month: 'Mes',
                                week: 'Semana',
                                day: 'Día',
                                list: 'Lista',
                            },

                            //Traducir texto de "All Day"
                            allDayText: 'Todo el día',

                            // Traducir texto de "No events to display"
                            noEventsText: 'No hay eventos para mostrar',

                            // Tipo de vista inicial
                            initialView: 'timeGridWeek',

                            // Hora minima y máxima del día a mostrar, Hora de inicio y fin obtenida de config/schedule
                            slotDuration: "00:15:00",
                            slotMinTime: "{{ config('schedule.start_time') }}",
                            slotMaxTime: "{{ config('schedule.end_time') }}",

                            // Scroll a hora actual al cargar la vista
                            scrollTime: "{{ date('H:i:s') }}",

                            events: {
                                url: '{{ route('api.appointments.index') }}',
                                failure: function() {
                                    alert('Error al cargar las citas');
                                    console.warn('Error al cargar los eventos');
                                },
                            },
                        });

                        // Renderizar el calendario
                        calendar.render();

                    }
                };
            }
        </script>
    @endpush

</x-admin-layout>
