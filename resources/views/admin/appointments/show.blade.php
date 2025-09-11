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
        'name' => 'Detalle',
    ],
]">

    <x-wire-card>

        {{-- Cabecera del detalle de la cita --}}
        <x-slot name="title">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detellade de la cita</h1>
            </div>

            <p class="text-sm text-gray-500">
                Fecha: {{ $appointment->date->format('d/m/Y') }}
            </p>
        </x-slot>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Sección de paciente --}}
            <div>
                <h2 class="font-semibold text-gray-500 uppercase text-xs mb-2">
                    Paciente
                </h2>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $appointment->patient->user->name }}
                </p>

                <p class="text-sm text-gray-600">
                    {{ $appointment->patient->user->email }}
                </p>
            </div>

            {{-- Sección del médico --}}
            <div>
                <h2 class="font-semibold text-gray-500 uppercase text-xs mb-2">
                    Médico
                </h2>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $appointment->doctor->user->name }}
                </p>

                <p class="text-sm text-gray-600">
                    {{ $appointment->doctor->speciality->name ?? 'Sin especialidad' }}
                </p>

            </div>

        </div>

        <hr class="my-6">

        {{-- Diagnostico de la cita --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Diagnostico:
            </h3>

            <p>
                {{ $appointment->consultation->diagnosis ?? 'No disponible' }}
            </p>
        </div>

        <hr class="my-6">

        {{-- Tratamiendo para el paciente --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Plan de tratamiento:
            </h3>

            <p>
                {{ $appointment->consultation->treatment ?? 'No disponible' }}
            </p>
        </div>

        {{-- Si existe "receta" --}}
        @isset($appointment->consultation->prescriptions)
            <hr class="my-6">

            {{-- Receta médica --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Receta médica:
                </h3>

                <ul class="space-y-3">
                    @foreach ($appointment->consultation->prescriptions as $prescription)
                        <li>
                            <p><strong>Medicamento:</strong> {{ $prescription['medicine'] }}</p>
                            <p><strong>Dosis:</strong> {{ $prescription['dosage'] }}</p>
                            <p><strong>Instrucciones:</strong> {{ $prescription['frequency'] }}</p>

                        </li>
                    @endforeach
                </ul>

            </div>
        @endisset

        {{-- Notas del médico (Solo para un usario "Doctor") --}}
        {{-- C67: Permiso por Rol --}}
        @role('Doctor')
            <hr class="my-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Notas le médico:
                </h3>
                <p>
                    {{ $appointment->consultation->notes ?? 'No hay notas'}}
                </p>
            </div>
        @endrole

    </x-wire-card>

</x-admin-layout>
