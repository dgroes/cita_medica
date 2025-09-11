<div>
    <div class="grid lg:grid-cols-4 gap-6 mb-8">
        {{-- Sección de Bienvenida 🙋‍♂️ --}}
        <x-wire-card class="md:col-span-2">
            <p class="text-2xl font-bold text-gray-800">
                ¡Buen día, Dr(a). {{ auth()->user()->name }}!
            </p>

            <p class="mt-1 text-gray-800">
                Aquí está el resumen de su jornada.
            </p>
        </x-wire-card>


        {{-- Visualización de citas de Hoy  --}}
        <x-wire-card>
            <p class="text-sm font-semibold text-gray-500">
                Citas de hoy
            </p>
            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data['appointments_today_count'] }}
            </p>
        </x-wire-card>

        {{-- Visualización de las citas de la semana --}}
        <x-wire-card>
            <p class="text-sm font-semibold text-gray-500">
                Citas de la semana
            </p>
            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data['appointments_week_count'] }}
            </p>
        </x-wire-card>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        <div>
            {{-- Proximan cita del doctor --}}
            <x-wire-card>
                <p class="text-lg font-semibold text-gray-900">
                    Próxima Cita
                </p>

                {{-- Mostrar cita si la hay --}}
                @if ($data['next_appointment'])
                    <p class="mt-4 font-semibold text-gray-800">
                        {{ $data['next_appointment']->patient->user->name }}
                    </p>

                    <p class="text-gray-600 mb-4">
                        {{ $data['next_appointment']->date->format('d/m/Y') }} a las
                        {{ $data['next_appointment']->start_time->format('H:i A') }}
                    </p>

                    <x-wire-button href="{{ route('admin.appointments.consultation', $data['next_appointment']) }}"
                        class="w-full">
                        Getionar cita
                    </x-wire-button>
                @else
                    <p class="mt-2 text-gray-500">
                        No tiene citas programadas para hoy.
                    </p>
                @endif
            </x-wire-card>

        </div>

        {{-- Sección de Citas programadas para hoy --}}
        <div class="lg:col-span-2">
            <x-wire-card>
                <p class="font-lg font-semibold text-gray-900">
                    Agenda para hoy
                </p>
                <ul class="mt-3 divide-y divide-gray-200">
                    @forelse ($data['appointments_today'] as $appointment)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $appointment->patient->user->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $appointment->date->format('d/m/Y') }} a las
                                    {{ $appointment->start_time->format('H:i A') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.appointments.consultation', $appointment) }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800">
                                Gestionar cita
                            </a>
                        </li>
                    @empty
                        <li>
                            <p class="py-2 text-gray-500">
                                No tiene citas programadas para hoy.
                            </p>
                        </li>
                    @endforelse
                </ul>
            </x-wire-card>
        </div>
    </div>
</div>
