<div>
    {{-- C56: Consultation(2) --}}
    {{-- información del paciente --}}
    <div class="lg:flex lg:justify-between lg:items-center mb-4">

        {{-- Nombre y DNI del paciente --}}
        <div>
            <p class="text-2xl font-bold text-gray-900 mb-1">
                {{ $appointment->patient->user->name }}
            </p>

            <p class="text-sm font-semibold text-gray-500">
                RUN: {{ $appointment->patient->user->dni ?? 'N/A' }}
            </p>
        </div>

        {{-- Botones de Historial medico y consultas anteriores --}}
        <div class="lg:flex lg:space-x-3 space-y-2 lg:space-y-0 mt-4 lg:mt-0">
            <x-wire-button class="w-full lg:w-auto" outline gray sm x-on:click="$openModal('historyModal')">
                <i class="fa-solid fa-notes-medical"></i>
                Ver Historia
            </x-wire-button>

            <x-wire-button class="w-full lg:w-auto" outline gray sm x-on:click="$openModal('previousConsultationsModal')">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Consultas Anteriores
            </x-wire-button>
        </div>
    </div>

    {{-- Tabs: Consulta méidca y Recetas médicas --}}
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
                        <div class="bg-gray-50 p-4 rounded-lg border lg:flex gap-4 space-y-4 lg:space-y-0"
                            wire:key="prescription-{{ $index }}">

                            {{-- Medicamento --}}
                            <div class="flex-1">
                                <x-wire-input label="Medicamento" placeholder="Ej: Paracetamol 500mg"
                                    wire:model="form.prescriptions.{{ $index }}.medicine" />
                            </div>

                            {{-- Dosis --}}
                            <div class="lg:w-32">
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
                            <div class="flex-shrink-0 lg:pt-7">
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
            <x-wire-button wire:click="save" spinner="save"
                :disabled="!$appointment->status->isEditable()"
            >
                <i class="fa-solid fa-save mr-2"></i>
                Guardar Consulta
            </x-wire-button>
        </div>

    </x-wire-card>

    {{-- Modal de historial médico del paciente --}}
    <x-wire-modal-card title="Historia médica del paciente" name="historyModal" width="5xl">
        <div class="grid lg:grid-cols-4 gap-6">

            {{-- Tipo de sangre del paciente --}}
            <div>
                <p class="font-medium text-gray-500 mb-1">
                    Tipo de sangre:
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $patient->bloodType?->name ?? 'No registrado' }}
                </p>
            </div>

            {{-- Alergias del paciente --}}
            <div>
                <p class="font-medium text-gray-500 mb-1">
                    Alergias:
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $patient->allergies ?? 'No registrado' }}
                </p>
            </div>

            {{-- Enfermedades crónicas del paciente --}}
            <div>
                <p class="font-medium text-gray-500 mb-1">
                    Enfermedades crónicas:
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $patient->chronic_conditions ?? 'No registrado' }}
                </p>
            </div>

            {{-- Antecendentes quirúrgicos del paciente --}}
            <div>
                <p class="font-medium text-gray-500 mb-1">
                    Antecedentes quirúrgicos:
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $patient->surgical_history ?? 'No registrado' }}
                </p>
            </div>

        </div>

        <x-slot name="footer">
            <div class="flex justify-end">
                <a href="{{ route('admin.patients.edit', $patient->id) }}"
                    class="font-semibold text-blue-600 hover:text-blue-800" target="_blank">
                    Ver / Editar Historia Médica
                </a>
            </div>
        </x-slot>

    </x-wire-modal-card>

    {{-- Modal de consultas anteriores del paciente --}}
    <x-wire-modal-card title="Consultas anteriores" name="previousConsultationsModal" width="4xl">
        @forelse ($previousConsultations as $consultation)
            <a href="{{ route('admin.appointments.consultation', $consultation->appointment_id) }}"
                class="block p-5 rounded-lg shadow-md border-gray-200 hover:border-indigo-400 hover:shadow-indigo-100 transition-all duration-200"
                target="_blank">

                <div class="lg:flex justify-between items-center space-y-2 lg:space-y-0">

                    <div>
                        <p class="font-semibold text-gray-800 flex items-center">
                            <i class="fa-solid fa-calendar-days text-gray-500 mr-2"></i>
                            {{ $consultation->appointment->date->format('d/m/Y H:i') }}
                        </p>

                        <p>
                            Atendido por:
                            Dr(a). {{ $consultation->appointment->doctor->user->name }}
                        </p>
                    </div>

                    <div>
                        <x-wire-button class="w-full lg:w-auto">
                            VER DETALLE
                        </x-wire-button>
                    </div>

                </div>

            </a>

        @empty

            <div class="text-center py-10 rounded-xl border border-dashed">
                <i class="fa-solid fa-inbox text-4xl text-gray-300"></i>

                <p class="mt-4 text-sm font-medium text-gray-500">
                    No se encontraron consultas previas a esta para este paciente.
                </p>

            </div>
        @endforelse

        {{-- Botón para cerrar el modal --}}
        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                {{-- C58: Buscar todas las consultas --}}
                <x-wire-button
                    href="{{ route('admin.appointments.index', ['namePatient' => $consultation->appointment->patient->user->name]) }}"
                >
                    Ver todas las consultas en detalle
                </x-wire-button>

                <x-wire-button outline gray sm x-on:click="$closeModal('previousConsultationsModal')">
                    Cerrar
                </x-wire-button>
            </div>
        </x-slot>

    </x-wire-modal-card>
</div>
