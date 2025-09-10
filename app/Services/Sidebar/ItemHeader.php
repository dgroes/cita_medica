<?php

namespace App\Services\Sidebar;

use Illuminate\Support\Facades\Gate;

// C63: Refacorizar Sidebar
class ItemHeader implements ItemSidebar
{
    private string $title;
    private array $can;

    public function __construct(string $title, array $can)
    {
        $this->title = $title;
        $this->can = $can;
    }

    public function render(): string
    {
        return <<<HTML
            <div class="px-2 py-2 text-xs font-semibold text-teal-500 uppercase">
                {$this->title}
            </div>
        HTML;
    }

    // Mëtodo para verificar si el usario tiene "los permisos" para visualizar "header" (el sidebar)
    public function authorize(): bool
    {
        // Si hay un "elemento" dentro de "can" da True, sino False
        return count($this->can)
            ? Gate::any($this->can)
            : true;
    }
}
