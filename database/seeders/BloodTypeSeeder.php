<?php

namespace Database\Seeders;

use App\Models\BloodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloodTypes = [
            'A+',
            'A-',
            'B+',
            'B-',
            'AB+',
            'AB-',
            'O+',
            'O-'
        ];

        foreach ($bloodTypes as $types) {
            try {
                BloodType::create(['name' => $types]);
                $this->command->info("[OK] Tipo de sangre creado 🩸: $types. ");
            } catch (\Exception $e) {
                $this->command->error("Error al crear el tipo de sangre: $types. 🩸 Mensaje: " . $e->getMessage());
            }
        }
    }
}
