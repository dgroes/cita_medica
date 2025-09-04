<?php

namespace App\Enums;

enum AppointmentEnum: int
{
    case SCHEDULED = 1;
    case COMPLETED = 2;
    case CANCELLED = 3;

    public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Programado',
            self::COMPLETED => 'Completado',
            self::CANCELLED => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SCHEDULED => 'blue',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
        };
    }

    public function colorHex(): string
    {
        return match ($this) {
            self::SCHEDULED => '#3490dc', // Azul
            self::COMPLETED => '#38c172', // Verde
            self::CANCELLED => '#e3342f', // Rojo
        };
    }

    //Método para verificar si una cita es editable
    public function isEditable(): bool
    {
        return $this === self::SCHEDULED;
    }
}
