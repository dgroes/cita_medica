{{-- C17: Migas de pan (breadcrumb) --}}
{{-- Verifica si hay elementos en el array de breadcrumbs --}}
@if (count($breadcrumbs))

    <nav class="mb-4">

        {{-- Lista ordenada de los items del breadcrumb --}}
        <ol class="flex flex-wrap">
            @foreach ($breadcrumbs as $item)
                <li
                    class="text-sm leading-normal text-slate-700 {{ !$loop->first ? "pl-2 before:float-left before:pr-2 before:content-['/']" : '' }}">
                    {{-- Si el item tiene una URL, lo muestra como enlace --}}
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="opacity-50">
                            {{ $item['name'] }}
                        </a>
                    {{-- Si no tiene URL, solo muestra el nombre como texto plano --}}
                    @else
                        {{ $item['name'] }}
                    @endisset
                </li>
            @endforeach
        </ol>

        {{-- Si hay más de un breadcrumb, muestra el nombre del último como título --}}
        @if (count($breadcrumbs) > 1)
            <h6 class="text-xl font-bold">
                {{ end($breadcrumbs)['name'] }}
            </h6>
        @endif
    </nav>

@endif
