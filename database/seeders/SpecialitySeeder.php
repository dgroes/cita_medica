<?php

namespace Database\Seeders;

use App\Models\Speciality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialities = [
            [
                'name' => 'Cardiología',
                'description' => 'Enfermedades del corazón y sistema circulatorio'
            ],
            [
                'name' => 'Neurología',
                'description' => 'Trastornos del sistema nervioso'
            ],
            [
                'name' => 'Pediatría',
                'description' => 'Atención médica para niños y adolescentes'
            ],
            [
                'name' => 'Dermalogía',
                'description' => 'Enfermedades de la piel, cabello y uñas'
            ],
            [
                'name' => 'Obstetricia',
                'description' => 'Atención médica durante el embarazo y parto'
            ],
            [
                'name' => 'Ginecología',
                'description' => 'Salud del sistema reproductivo femenino'
            ],
            [
                'name' => 'Oftalmología',
                'description' => 'Enfermedades de los ojos y visión'
            ],
            [
                'name' => 'Psiquiatría',
                'description' => 'Trastornos mentales y emocionales'
            ],
            [
                'name' => 'Traumatología',
                'description' => 'Lesiones y enfermedades del sistema musculoesquelético'
            ],
            [
                'name' => 'Endocrinología',
                'description' => 'Trastornos hormonales y metabólicos'
            ]
        ];

        foreach ($specialities as $data) {
            Speciality::create($data);
        }
    }
}
