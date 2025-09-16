<x-admin-layout title="Citas | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Gestión',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Calendario',
    ],
]">
    {{-- C60: Modal de calendario --}}
    {{-- Modificación de CSS del calendario --}}
    @push('css')
        <style>
            .fc-event {
                cursor: pointer;
            }
        </style>
    @endpush


    {{-- C59: Calendario --}}
    {{-- Inicializar Alpine --}}
    <div x-data="data()">

        {{-- Modal de la cita en el calendar --}}
        <x-wire-modal-card title="Cita Médica" name="appointmentModal" width="md" align="center">
            <div class="space-y-4 mb-4">

                {{-- Fecha y hora de la Consulta --}}
                <div>
                    <strong>Fecha y Hora:</strong>
                    <span x-text="selectedEvent.dateTime"></span>
                </div>

                {{-- Paciente de la consulta --}}
                <div>
                    <strong>Paciente:</strong>
                    <span x-text="selectedEvent.patient"></span>
                </div>

                {{-- Médico de la consulta --}}
                <div>
                    <strong>Médico:</strong>
                    <span x-text="selectedEvent.doctor"></span>
                </div>

                {{-- Estado de la consulta --}}
                <div>
                    <strong>Estado:</strong>
                    <span x-text="selectedEvent.status"></span>
                </div>

            </div>

            {{-- Botón para Ir a gestión de la Cita --}}
            <a x-bind:href="selectedEvent.url" class="w-full">
                <x-wire-button class="w-full">
                    Gestionar Cita
                </x-wire-button>
            </a>

        </x-wire-modal-card>

        <div x-ref='calendar'></div>
    </div>

    @push('js')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>

        <script>
            function data() {
                return {

                    selectedEvent: {
                        dateTime: null,
                        patient: null,
                        doctor: null,
                        status: null,
                        color: null,
                        url: null,
                    },

                    openModal(info) {
                        this.selectedEvent = {
                            dateTime: info.event.extendedProps.dateTime,
                            patient: info.event.extendedProps.patient,
                            doctor: info.event.extendedProps.doctor,
                            status: info.event.extendedProps.status,
                            color: info.event.extendedProps.color,
                            url: info.event.extendedProps.url
                        };

                        $openModal('appointmentModal');
                    },


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

                            hiddenDays: [0], // 👈 Esto oculta el domingo

                            events: {
                                url: '{{ route('api.appointments.index') }}',
                                failure: function() {
                                    alert('Error al cargar las citas');
                                    console.warn('Error al cargar los eventos');
                                },
                            },

                            // Evento para enviar información al modal
                            eventClick: (info) => this.openModal(info),

                            // Scroll a hora actual al cargar la vista
                            scrollTime: "{{ date('H:i:s') }}",

                        });

                        // Renderizar el calendario
                        calendar.render();

                    }
                };
            }
        </script>
    @endpush

</x-admin-layout>
