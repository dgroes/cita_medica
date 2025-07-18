{{-- C42: Descomponiendo Edit en componentes Blade  --}}
@props(['active' => 'default'])

<div class="" x-data ="{ active: '{{ $active }}' }">
    @isset($header)
    {{-- Primer slot (slot header) --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            {{ $header }}
        </ul>
    </div>
    @endisset


    {{-- Segundo slot (slot principal) --}}
    <div class="px-4 mt-4">
        {{ $slot }}
    </div>
</div>
