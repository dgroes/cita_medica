{{-- C09: Componente con clase --}}
{{-- C16: @Props --}}
@props([
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => [],
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Font Awesome 🏳️ --}}
    <script src="https://kit.fontawesome.com/335ff06f37.js" crossorigin="anonymous"></script>

    {{-- ## C26: SweetAlert2 (con Session->fash()) --}}
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- WireUI --}}
    @wireUiScripts

    <!-- AlPine:Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @stack('css')
</head>

<body class="font-sans antialiased">

    {{-- C10: Estrucura de las view/routes/controller/layouts/etc --}}
    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

    <div class="p-4 md:ml-64">

        <div class="mt-14 flex items-center">
            @include('layouts.includes.admin.breadcrumb')

            @isset($action)
                <div class="ml-auto">
                    {{ $action }}
                </div>
            @endisset

        </div>
        {{ $slot }}

    </div>

    @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    {{-- C26: SweetAlert2 (con Session->fash()) --}}
    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')))
        </script>
    @endif

    {{-- Mensaje de guardado de horario --}}
    {{-- C46: Alerta de SweetAlert2 con Livewire --}}
    <script>
        Livewire.on('swal', (data) => {
            Swal.fire(data)
        })
    </script>

    <script>
        forms = document.querySelectorAll('.delete-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "No podrás revertir los cambios!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!",
                    cancelButtonText: "Cancelar"

                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            })
        })
    </script>
    @stack('js')
</body>

</html>
