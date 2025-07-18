{{-- C42: Descomponiendo Edit en componentes Blade  --}}
@props(['tab' => 'default'])
<div x-show="active === '{{ $tab }}'">
    {{ $slot }}
</div>
