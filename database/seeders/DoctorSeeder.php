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
                'phone' => '56999887766',
                'biography' => 'Dr. John Doe es un cardiólogo con más de 10 años de experiencia en el tratamiento de enfermedades del corazón.'
            ],
            [
                'user_id' => 2,
                'speciality_id' => 2, // Neurología
                'medical_license_number' => 'MED654321',
                'phone' => '56911335483',
                'biography' => 'Dra. Jane Smith es una neuróloga especializada en trastornos del sistema nervioso.'
            ],
            [
                'user_id' => 3,
                'speciality_id' => 3, // Pediatría
                'medical_license_number' => 'MED789012',
                'phone' => '56922334455',
                'biography' => 'Dr. Mike Johnson es un pediatra dedicado a la salud infantil con más de 15 años de experiencia.'
            ],
            [
                'user_id' => 4,
                'speciality_id' => 4, // Dermatología
                'medical_license_number' => 'MED345678',
                'phone' => '56933445566',
                'biography' => 'Dra. Emily Davis es una dermatóloga experta en enfermedades de la piel, cabello y uñas.'
            ],
            [
                'user_id' => 5,
                'speciality_id' => 5, // Obstetricia
                'medical_license_number' => 'MED901234',
                'phone' => '56944556677',
                'biography' => 'Dr. Sarah Wilson es una obstetra con amplia experiencia en el cuidado de mujeres durante el embarazo y parto.'
            ],
            [
                'user_id' => 6,
                'speciality_id' => 6, // Ginecología
                'medical_license_number' => 'MED567890',
                'phone' => '56955667788',
                'biography' => 'Dra. Laura Brown es una ginecóloga especializada en salud del sistema reproductivo femenino.'
            ],
            [
                'user_id' => 7,
                'speciality_id' => 7, // Oftalmología
                'medical_license_number' => 'MED123789',
                'phone' => '56966778899',
                'biography' => 'Dr. James Taylor es un oftalmólogo con experiencia en enfermedades de los ojos y visión.'
            ],
            [
                'user_id' => 8,
                'speciality_id' => 8, // Psiquiatría
                'medical_license_number' => 'MED456012',
                'phone' => '56977889900',
                'biography' => 'Dra. Patricia Martinez es una psiquiatra especializada en trastornos mentales y emocionales.'
            ],
            [
                'user_id' => 9,
                'speciality_id' => 9, // Traumatología
                'medical_license_number' => 'MED789345',
                'phone' => '56988990011',
                'biography' => 'Dr. Robert Garcia es un traumatólogo experto en lesiones y enfermedades del sistema musculoesquelético.'
            ],
            [
                'user_id' => 10,
                'speciality_id' => 10, // Endocrinología
                'medical_license_number' => 'MED012678',
                'phone' => '56999001122',
                'biography' => 'Dra. Angela Rodriguez es una endocrinóloga especializada en trastornos hormonales y metabólicos.'
            ]

        ];

        foreach ($doctors as $doctor){
            try {
                Doctor::created($doctor);
                $this->command->info("[OK] Doctor {$doctor['user_id']} creado exitosamente 🩺");
            } catch (\Exception $e) {
                $this->command->error("[ERROR] No se pudo crear el doctor {$doctor['user_id']}: " . $e->getMessage());
            }
        }
    }
}
