<?php

namespace App\Services\Sidebar;

// C63: Refacorizar Sidebar
class ItemGroup implements ItemSidebar
{
    protected string $title;
    protected string $icon;
    protected string $active;
    protected array $items = [];

    public function __construct(string $title, string $icon, string $active)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->active = $active;
    }

    public function add(ItemLink $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public function render(): string
    {
        // Con array_filter se recupera cada elmento del array $items
        // Con esto se puede agrega una validación, lo que mostrará será los "items" a los que se tiene autorización
        $items = array_filter($this->items, function ($item) {
            return $item->authorize();
        });

        return view('sidebar.item-group', [
            'title' => $this->title,
            'icon' => $this->icon,
            'active' => $this->active,
            'items' => $items, /* <- aquí van los items ya filtrados  */
        ])->render();
    }

    public function authorize(): bool
    {
        // Iterar items del objeto ($item viene de ItemLink), para verificar si está autorizado para ver
        foreach ($this->items as $item) {
            if ($item->authorize()) {
                return true;
            }
        }

        return false;
    }
}

