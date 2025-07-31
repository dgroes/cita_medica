<div>

    <x-wire-card>
        <p class="text-xl font-semibold mb-1 text-slate-800">
            Buscar disponibilidad
        </p>

        <p>
            Encuentra el horario perfecto para tu cita
        </p>

        <div class="grid gird-cols-1 lg:grid-cols-4 gap-4">
            {{-- Input de Fecha --}}
             <x-wire-input
                label="Fecha"
                type="date"
                wire:model="search.date"
                placeholder="Selecciona una fecha"
            />
            {{-- Input de Horas --}}
            <x-wire-select
                label="Hora"
                 wire:model="search.hour"
                icon="clock"
                placeholder="Seleccione una hora">
                 @foreach ($this->hourBlocks as $hourBlock)

                        <x-wire-select.option
                            :label="$hourBlock->copy()->format('H:i:s') . ' - ' . $hourBlock->copy()->addHour()->format('H:i:s')"
                            :value="$hourBlock->format('H:i:s')"
                        />

                    @endforeach
            </x-wire-select>

            {{-- Input de Especialidad --}}
            <x-wire-select
                 label="Especialidad (opcional)"
                icon="sparkles"
                wire:model="search.speciality_id"
                placeholder="Selecciona una especialidad">

                @foreach ($specialties as $speciality)

                    <x-wire-select.option
                        :label="$speciality->name"
                        :value="$speciality->id"
                    />

                @endforeach
            </x-wire-select>

            <div class="lg:pt-7">
               <x-wire-button
                    wire:click="searchAvailability"
                    class="w-full"
                    color="primary"
                    {{-- :disabled="$appointmentEdit && !$appointmentEdit->status->isEditable()" --}}
                >
                    Buscar disponibilidad
                </x-wire-button>

            </div>

        </div>

    </x-wire-card>

</div>
