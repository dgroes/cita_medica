<x-admin-layout title="Pacientes | CitasMédicas" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        <x-wire-card class="mb-2">
            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center space-x-5">
                    <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}"
                        class="size-20 rounded-full object-cover object-center">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $patient->user->name }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
                        Volver
                    </x-wire-button>
                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Guardar cambios
                    </x-wire-button>
                </div>

            </div>
        </x-wire-card>

        {{-- Tabs --}}
        <x-wire-card>
            {{-- C41: Contenedor principal con AlpineJS --}}
            {{-- C42: Descomponiendo Edit en componentes Blade --}}
            <x-tabs active="datos-personales">

                {{-- Pestañas de navegación --}}
                <x-slot name="header">

                    {{-- Pestaña: Datos personales --}}
                    <x-tab-link tab="datos-personales">
                        <i class="fa solid fa-user me-2"></i>
                        Datos personales
                    </x-tab-link>

                    {{-- Pestaña: Antecedentes --}}
                    <x-tab-link tab="antecedentes">
                        <i class="fa-solid fa-file-lines me-2"></i>
                        Antecedentes
                    </x-tab-link>

                    {{-- Pestaña: Información General --}}
                    <x-tab-link tab="informacion-general">
                        <i class="fa-solid fa-info me-2"></i>
                        Información General
                    </x-tab-link>

                    {{-- Pestaña: Contacto de emergencia --}}
                    <x-tab-link tab="contacto-emergencia">
                        <i class="fa-solid fa-phone me-2"></i>
                        Contacto de emergencia
                    </x-tab-link>

                </x-slot>

                {{-- Tab content (Contenedor de contenido de las pestañas) --}}
                {{-- C40: Helper dentro de una View de Blade --}}
                @php
                    $formattedPhone = \App\Helpers\FormatHelper::phone($patient->user->phone);
                @endphp

                {{-- Contenido de cada tab --}}
                {{-- Datos Pesonales --}}
                <x-tab-content tab="datos-personales">

                    {{-- Componente de tarjeta de WireUI --}}
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

                </x-tab-content>

                {{-- Antecedentes --}}
                <x-tab-content tab="antecedentes">

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
                </x-tab-content>

                {{-- Información General --}}
                <x-tab-content tab="informacion-general">

                    {{-- Edad del paciente --}}
                    <x-wire-datetime-picker label="Fecha de nacimiento" name="date_of_birth" without-time="true"
                        clearable="false" max="{{ now()->format('Y-m-d') }}" class="mb-4" :value="old('date_of_birth', $patient->date_of_birth)" />

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
                </x-tab-content>

                {{-- Contacto de Emergencia --}}
                <x-tab-content tab="contacto-emergencia">

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
                </x-tab-content>


            </x-tabs>

        </x-wire-card>

    </form>

</x-admin-layout>
