<?php

namespace App\Helpers;

/* C30: Laravel Livewire Table personalizada */
/* C39: Helpers Personalizado */
class FormatHelper
{
    public static function run($run)
    {
        // Limpiar todo menos números y la letra k (en minúscula)
        $run = preg_replace('/[^0-9kK]/', '', $run);

        // Separar dígito verificador
        $dv = strtoupper(substr($run, -1));
        $num = substr($run, 0, -1);

        // Formatear con puntos
        $formatted = number_format($num, 0, '', '.');

        return $formatted . '-' . $dv;
    }

      public static function phone($phone)
    {
        // Asgurarse que solo debe tener solo dígitos
        $digits = preg_replace('/\D/', '', $phone);

        // Verificar longitud esperada (ej: 11 dígitos: 56 9 XXXX XXXX)
        if (strlen($digits) === 11 && substr($digits, 0, 3) === '569') {
            $country = substr($digits, 0, 2); // 56
            $carrier = substr($digits, 2, 1); // 9
            $part1 = substr($digits, 3, 4);   // XXXX
            $part2 = substr($digits, 7);      // XXXX
            return "{$country} {$carrier} {$part1} {$part2}";
        }

        // Si no cumple el formato esperado, devuelve sin cambios
        return $phone;
    }
}
