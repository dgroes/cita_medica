<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'user_id' => 1,
                'speciality_id' => 1, // Cardiología
                'medical_license_number' => 'MED123456',
                'biography' => 'Dr. Clegane es un cardiólogo con más de 10 años de experiencia en el tratamiento de enfermedades del corazón.'
            ],
            [
                'user_id' => 2,
                'speciality_id' => 2, // Neurología
                'medical_license_number' => 'MED654321',
                'biography' => 'Dr. Tyrion Lannister es una neuróloga especializada en trastornos del sistema nervioso.'
            ],
            [
                'user_id' => 3,
                'speciality_id' => 3, // Pediatría
                'medical_license_number' => 'MED789012',
                'biography' => 'Dr. Jeor Mormont es un pediatra dedicado a la salud infantil con más de 15 años de experiencia.'
            ],
            [
                'user_id' => 4,
                'speciality_id' => 4, // Dermatología
                'medical_license_number' => 'MED345678',
                'biography' => 'Dr. Samwell Tarly es una dermatóloga experta en enfermedades de la piel, cabello y uñas.'
            ],
            [
                'user_id' => 5,
                'speciality_id' => 5, // Obstetricia
                'medical_license_number' => 'MED901234',
                'biography' => 'Dra. Arya Stark es una obstetra con amplia experiencia en el cuidado de mujeres durante el embarazo y parto.'
            ],
            [
                'user_id' => 6,
                'speciality_id' => 6, // Ginecología
                'medical_license_number' => 'MED567890',
                'biography' => 'Dra. Brienne de Tarth es una ginecóloga especializada en salud del sistema reproductivo femenino.'
            ],
            /* [
                'user_id' => 7,
                'speciality_id' => 7, // Oftalmología
                'medical_license_number' => 'MED123789',
                'biography' => 'Dr. Davos Seaworth es un oftalmólogo con experiencia en enfermedades de los ojos y visión.'
            ], */
            [
                'user_id' => 8,
                'speciality_id' => 8, // Psiquiatría
                'medical_license_number' => 'MED456012',
                'biography' => 'Dra. Catelyn Stark es una psiquiatra especializada en trastornos mentales y emocionales.'
            ],
            [
                'user_id' => 9,
                'speciality_id' => 9, // Traumatología
                'medical_license_number' => 'MED789345',
                'biography' => 'Dr. Petyr Baelish es un traumatólogo experto en lesiones y enfermedades del sistema musculoesquelético.'
            ],

        ];

        foreach ($doctors as $doctor){
            try {
                Doctor::create($doctor);
                $this->command->info("[OK] Doctor (user_id: {$doctor['user_id']}) creado exitosamente 🩺");
            } catch (\Exception $e) {
                $this->command->error("[ERROR] No se pudo crear el doctor {$doctor['user_id']}: " . $e->getMessage());
            }
        }
    }
}
