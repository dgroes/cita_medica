<div>
    <x-wire-card>
        <div class="text-center">

            {{-- Mensaje de bienvenida --}}
            <p class="text-2xl font-semibold text-gray-800">
                Bienvenido, {{ auth()->user()->name }}
            </p>

            <p class="mt-2 text-gray-600 ">
                Aquí está el resumen del panetl de control.
            </p>

            <div class="flex justify-center mt-4">
                {{-- <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" /> --}}
                <x-wire-button href="{{ route('admin.appointments.create') }}">
                    Reservar nueva cita
                </x-wire-button>
            </div>

        </div>
    </x-wire-card>

    <div class="grid lg:grid-cols-3 gap-8 mt-8">
        {{-- Última cita --}}
        <div>

            {{-- Proximan cita del paciente --}}
            <x-wire-card>
                <p class="text-lg font-semibold text-gray-900">
                    Última cita
                </p>

                {{-- Mostrar cita si la hay --}}
                @if ($data['next_appointment'])
                    <p class="mt-4 font-semibold text-gray-800">
                        Dr(a): {{ $data['next_appointment']->doctor->user->name }}
                    </p>

                    <p class="text-gray-600 mb-4">
                        {{ $data['next_appointment']->date->format('d/m/Y') }} a las
                        {{ $data['next_appointment']->start_time->format('H:i A') }}
                    </p>

                    <x-wire-button href="{{ route('admin.appointments.show', $data['next_appointment']) }}"
                        class="w-full">
                        Detalle de cita
                    </x-wire-button>
                @else
                    <p class="mt-2 text-gray-500">
                        No tiene citas programadas para hoy.
                    </p>
                @endif
            </x-wire-card>

        </div>

        {{-- Citas previas --}}
        <div class="lg:col-span-2">
            <x-wire-card>
                <p class="font-lg font-semibold text-gray-900">
                    Citas pasadas
                </p>
                <ul class="mt-3 divide-y divide-gray-200">
                    @forelse ($data['past_appointment'] as $appointment)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $appointment->doctor->user->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $appointment->date->format('d/m/Y') }} a las
                                    {{ $appointment->start_time->format('H:i A') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.appointments.show', $appointment) }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800">
                                Ver consulta
                            </a>
                        </li>
                    @empty
                        <li>
                            <p class="py-2 text-gray-500">
                                No tiene citas pasadas registradas
                            </p>
                        </li>
                    @endforelse
                </ul>
            </x-wire-card>
        </div>
    </div>
</div>
