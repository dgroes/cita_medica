<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            UserSeeder::class, // Seed de Doctores
            BloodTypeSeeder::class, // Seed de tipos de sangre
            SpecialitySeeder::class,
            DoctorSeeder::class, // Seed de doctores
            /* PatientSeeder::class, */ // Seed de pacientes (manteción)

        ]);


    }
}
