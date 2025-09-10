<?php

namespace App\Services\Sidebar;

// C63: Refacorizar Sidebar
interface ItemSidebar
{
    public function render(): string;

    public function authorize(): bool;
}

