{{-- Para mostár le menú abierto o cerrado --}}
<div x-data="{
    open: {{ $active ? 'true' : 'false' }}
}">
    <button type="button"
        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
        @click="open = !open">
        <span class="size-6 inline-flex justify-center items-center">
            <i class="{{ $icon }}"></i>
        </span>
        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $title }}</span>

        <i
            :class="{
                'fa-solid fa-chevron-up': open 'fa-solid fa-chevron-down': !open
            }">

        </i>

    </button>
    <ul x-show="open" x-cloak id="dropdown-example" class="py-2 space-y-2">
        @foreach ($items as $item)
            <li class="pl-4">
                {!! $item->render() !!}
            </li>
        @endforeach

    </ul>
</div>
