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
        @if (count($availability))
            <div class="grid lg:grid-cols-3 gap-4 lg:gap-8">
                <div class="col-span-1 lg:col-span-2">

                    {{-- Mostra doctores si los hay para las fecha y hora --}}
                    @foreach ($availability as $doctor)
                        <x-wire-card>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $doctor->user->profile_photo_url }}" alt="{{ $doctor->user->name }}"
                                    class="size-16 rounded-full object-cover">

                                <div>
                                    <p class="text-xl font-bold text-slate-800">
                                        {{ $doctor->user->name }}
                                    </p>
                                    <p class="text-sm text-cyan-600 font-medium">
                                        {{ $doctor->speciality->name ?? 'Sin especialidad' }}
                                    </p>
                                </div>
                            </div>

                            <hr class="my-5">
                            <div>
                                <p class="text-sm text-slate-600 mb-2 font-semibold">
                                    Horarios disponibles
                                </p>
                                <ul class="grid grid-col-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                    @foreach ($doctor->schedules as $schedule)
                                        <li>
                                            <x-wire-button
                                                x-on:click="selectSchedule({{ $doctor->id }}, '{{ $schedule->start_time->format('H:i:s') }}')"
                                                class="w-full">
                                                {{ $schedule->start_time->format('H:i:s') }}
                                            </x-wire-button>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </x-wire-card>
                    @endforeach

                </div>
                <div class="col-span-1">
                    @json($selectedSchedules)
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
                        this.selectedSchedules.doctor_id = doctorId;
                        this.selectedSchedules.schedules = schedule;
                    }
                }
            }
        </script>
    @endpush
</div>
