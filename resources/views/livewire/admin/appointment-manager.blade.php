<div x-data="data()">

    <x-wire-card class="mb-8">
        <p class="text-xl font-semibold mb-1 text-slate-800">
            Buscar disponibilidad
        </p>

        <p>
            Encuentra el horario perfecto para tu cita
        </p>

        <div class="grid gird-cols-1 lg:grid-cols-4 gap-4">
            {{-- Input de Fecha --}}
            <x-wire-input label="Fecha" type="date" wire:model="search.date" placeholder="Selecciona una fecha" />
            {{-- Input de Horas --}}
            <x-wire-select label="Hora" wire:model="search.hour" icon="clock" placeholder="Seleccione una hora">
                @foreach ($this->hourBlocks as $hourBlock)
                    <x-wire-select.option :label="$hourBlock->copy()->format('H:i:s') .
                        ' - ' .
                        $hourBlock->copy()->addHour()->format('H:i:s')" :value="$hourBlock->format('H:i:s')" />
                @endforeach
            </x-wire-select>

            {{-- Input de Especialidad --}}
            <x-wire-select label="Especialidad (opcional)" icon="sparkles" wire:model="search.speciality_id"
                placeholder="Selecciona una especialidad">

                @foreach ($specialties as $speciality)
                    <x-wire-select.option :label="$speciality->name" :value="$speciality->id" />
                @endforeach
            </x-wire-select>

            <div class="lg:pt-7">
                <x-wire-button wire:click="searchAvailability" class="w-full" color="primary" {{-- :disabled="$appointmentEdit && !$appointmentEdit->status->isEditable()" --}}>
                    Buscar disponibilidad
                </x-wire-button>

            </div>

        </div>

    </x-wire-card>

    @if ($appointment['date'])
        @if (count($availabilities))
            <div class="grid lg:grid-cols-3 gap-4 lg:gap-8">
                <div class="col-span-1 lg:col-span-2 space-y-6">

                    {{-- Mostra doctores si los hay para las fecha y hora --}}
                    @foreach ($availabilities as $availability)
                        <x-wire-card>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $availability['doctor']->user->profile_photo_url }}"
                                    alt="{{ $availability['doctor']->user->name }}"
                                    class="size-16 rounded-full object-cover">

                                <div>
                                    <p class="text-xl font-bold text-slate-800">
                                        {{ $availability['doctor']->user->name }}
                                    </p>
                                    <p class="text-sm text-cyan-600 font-medium">
                                        {{ $availability['doctor']->speciality->name ?? 'Sin especialidad' }}
                                    </p>
                                </div>
                            </div>

                            <hr class="my-5">
                            <div>
                                <p class="text-sm text-slate-600 mb-2 font-semibold">
                                    Horarios disponibles
                                </p>
                                <ul class="grid grid-col-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                    @foreach ($availability['schedules'] as $schedule)
                                        <li>
                                            <x-wire-button
                                                x-on:click="selectSchedule({{ $availability['doctor']->id }}, '{{ $schedule['start_time'] }}')"
                                                x-bind:class="selectedSchedules.doctor_id === {{ $availability['doctor']->id }} &&
                                                    selectedSchedules.schedules.includes(
                                                        '{{ $schedule['start_time'] }}') ? 'opacity-50' : ''"
                                                class="w-full">
                                                {{ $schedule['start_time'] }}
                                            </x-wire-button>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </x-wire-card>
                    @endforeach

                </div>

                {{-- C52: Búsqueda de disponibilidad, selección de horarios y resumen de cita --}}
                {{-- Datos de la cita a agendar (resumen de cita) --}}
                <div class="col-span-1">

                    <x-wire-card>
                        <p class="text-xl font-semibold mb-4 text-slate-800">
                            Resumen de la cita
                        </p>
                        <div class="space-y-3 text-sm">

                            {{-- Nombre del doc seleccionado --}}
                            <div class="flex- justify-between">
                                <span class="text-slate-500">
                                    Doctor:

                                </span>
                                <span class="font-semibold text-slate-700">
                                    {{ $this->doctorName }}
                                </span>
                            </div>

                            {{-- Fecha de la cita a agendar --}}
                            <div class="flex- justify-between">
                                <span class="text-slate-500">
                                    Fecha:
                                </span>
                                <span class="font-semibold text-slate-700">
                                    {{ $appointment['date'] }}
                                </span>
                            </div>

                            {{-- Horario de la cita --}}
                            <div class="flex- justify-between">
                                <span class="text-slate-500">
                                    Horario:
                                </span>
                                <span class="font-semibold text-slate-700">
                                    @if ($appointment['duration'])
                                        {{ $appointment['start_time'] }} - {{ $appointment['end_time'] }}
                                    @else
                                        Por definir
                                    @endif
                                </span>
                            </div>

                            {{-- Duración de cita --}}
                            <div class="flex- justify-between">
                                <span class="text-slate-500">
                                    Duración:
                                </span>
                                <span class="font-semibold text-slate-700">
                                    {{ $appointment['duration'] ?: 0 }} minutos
                                </span>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="space-y-6">

                            <x-wire-select label="Paciente" placeholder="Selecciona un paciente" :async-data="route('api.patients.index')"
                                wire:model="appointment.patient_id" icon="user" option-label="name"
                                option-value="id" />
                            <x-wire-textarea
                                wire:model="appointment.reason"
                                label="Motivo de la cita"
                                placeholder="Describe el motivo de la cita"
                                rows="3"
                                />

                            <x-wire-button
                                wire:click="save"
                                spinner="save"
                                class="w-full">
                                Confirmar cita
                            </x-wire-button>
                        </div>
                    </x-wire-card>
                </div>
            </div>
        @else
            <x-wire-card class="">
                <p>No hay disponibilidad para la fecha y hora seleccionada</p>
            </x-wire-card>
        @endif
    @endif

    @push('js')
        <script>
            function data() {
                return {
                    selectedSchedules: @entangle('selectedSchedules').live,
                    selectSchedule(doctorId, schedule) {

                        if (this.selectedSchedules.doctor_id !== doctorId) {
                            this.selectedSchedules = {
                                doctor_id: doctorId,
                                schedules: [schedule]
                            }

                            return;
                        }

                        let currentSchedules = this.selectedSchedules.schedules;
                        let newSchedules = [];

                        if (currentSchedules.includes(schedule)) {
                            newSchedules = currentSchedules.filter(s => s !== schedule);
                        } else {
                            newSchedules = [...currentSchedules, schedule];
                        }

                        if (this.isContiguous(newSchedules)) {
                            this.selectedSchedules = {
                                doctor_id: doctorId,
                                schedules: newSchedules
                            }
                        } else {
                            this.selectedSchedules = {
                                doctor_id: doctorId,
                                schedules: [schedule]
                            }

                        }


                    },
                    // Verifica si los horarios seleccionados son contiguos
                    isContiguous(schedules) {
                        if (schedules.length < 2) {
                            return true;
                        }

                        let sortedSchedules = schedules.sort();

                        for (let i = 0; i < sortedSchedules.length - 1; i++) {
                            let currentTime = sortedSchedules[i];
                            let nextTime = sortedSchedules[i + 1];

                            if (this.calculateNextTime(currentTime) !== nextTime) {
                                return false;
                            }
                        }

                        return true;
                    },
                    // Calcula el siguiente horario contiguo
                    calculateNextTime(time) {
                        let date = new Date(`1970-01-01T${time}`);
                        let duration = parseInt("{{ config('schedule.appointment_duration') }}");
                        date.setMinutes(date.getMinutes() + 15);
                        return date.toTimeString().split(' ')[0];
                    }
                }
            }
        </script>
    @endpush
</div>
