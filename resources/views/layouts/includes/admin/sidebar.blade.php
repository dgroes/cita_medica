{{-- C10: Estrucura de las view/routes/controller/layouts/etc --}}
{{-- C15: Composición dinámica de vistas mediante datos estructurados --}}
{{-- C63: Refacorizar Sidebar --}}
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($sidebarItems as $item)
                <li>
                    {!!  $item->render()!!}

                </li>
            @endforeach

        </ul>
    </div>
</aside>
