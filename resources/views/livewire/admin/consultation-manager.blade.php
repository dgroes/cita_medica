<div>
    {{-- C56: Consultation(2) --}}
    <x-wire-card class="mb-2">
        <div class="lg:flex lg:justify-between lg:items-center">
            <div class="flex items-center space-x-5">
                <img src="{{ $appointment->patient->user->profile_photo_url }}"
                    alt="{{ $appointment->patient->user->name }}" class="size-20 rounded-full object-cover object-center">
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $appointment->patient->user->name }}
                    </p>

                    <p class="text-sm font-semibold text-gray-500">
                        RUN: {{ $appointment->patient->user->dni ?? 'Sin RUN' }}
                    </p>
                </div>
            </div>
            <div class="flex space-x-3 mt-6 lg:mt-0">
                <x-wire-button outline gray>
                    <i class="fa-solid fa-notes-medical"></i>
                    Ver hisorial
                </x-wire-button>
                <x-wire-button outline gray>
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Consultas anteriores
                </x-wire-button>
            </div>

        </div>
    </x-wire-card>

    {{-- Tabs --}}
    <x-wire-card>
        <x-tabs active="consultation">

            {{-- Pestaña de navegación --}}
            <x-slot name="header">

                {{-- Pestaña: Consulta --}}
                <x-tab-link tab="consultation">
                    <i class="fa solid fa-user-doctor me-2"></i>
                    Consulta

                </x-tab-link>

                {{-- Pestaña: Receta --}}
                <x-tab-link tab="prescriptions">
                    <i class="fa solid fa-prescription-bottle-medical me-2"></i>
                    Receta
                </x-tab-link>
            </x-slot>

            {{-- Contenido de la pestaña "Consulta" --}}
            <x-tab-content tab="consultation">

                <div class="space-y-4">

                    {{-- Textarea de Diagnóstico --}}
                    <x-wire-textarea label="Diagnóstico" placeholeder="Descripción del diagnóstico"
                        wire:model="form.diagnosis" />

                    {{-- Textarea de Tratamiento --}}
                    <x-wire-textarea label="Tratamiento" placeholeder="Descripción del tratamiento"
                        wire:model="form.treatment" />

                    {{-- Textarea de Notas --}}
                    <x-wire-textarea label="Notas" placeholeder="Notas adicionales" wire:model="form.notes" />

                </div>

            </x-tab-content>

            {{-- Contenido de la pestaña "Receta" --}}
            <x-tab-content tab="prescriptions">
                <div class="space-y-4">
                    @forelse ($form['prescriptions'] as $index => $prescription)
                        <div class="bg-gray-50 p-4 rounded-lg border flex gap-4"
                            wire:key="prescription-{{ $index }}">

                            {{-- Medicamento --}}
                            <div class="flex-1">
                                <x-wire-input label="Medicamento" placeholder="Ej: Paracetamol 500mg"
                                    wire:model="form.prescriptions.{{ $index }}.medicine" />
                            </div>

                            {{-- Dosis --}}
                            <div class="w-32">
                                <x-wire-input label="Dosis" placeholder="Ej: 1/4 pastilla"
                                    wire:model="form.prescriptions.{{ $index }}.dosage" />
                            </div>

                            {{-- Frecuencia --}}
                            <div class="flex-1">
                                <x-wire-input label="Frecuencia de uso" placeholder="Ej: Cada 8 horas por 5 días"
                                    wire:model="form.prescriptions.{{ $index }}.frequency" />
                            </div>

                            {{-- Botón para eliminar la prescripción --}}
                            {{-- C57: Spinner de carga --}}
                            <div class="flex-shrink-0 pt-7">
                                <x-wire-mini-button sm red icon="trash"
                                    wire:click="removePrescription({{ $index }})"
                                    spinner="removePrescription({{ $index }})" />

                            </div>



                        </div>

                    @empty
                        <div class="text-center text-gray-500 py-6">
                            No hay medicamentos añadidos a la receta.
                        </div>
                    @endforelse

                </div>

                {{-- Botón para añadir un nuevo medicamento  --}}
                {{-- C57: Spinner de carga --}}
                <div class="mt-4">
                    <x-wire-button outline secondary wire:click="addPrescription" spinner="addPrescription">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Añadir medicamento
                    </x-wire-button>
                </div>

            </x-tab-content>
        </x-tabs>

        <div class="flex justify-end mt-6">
            <x-wire-button wire:click="save" spinner="save">
                <i class="fa-solid fa-save mr-2"></i>
                Guardar Consulta
            </x-wire-button>
        </div>

    </x-wire-card>
</div>
