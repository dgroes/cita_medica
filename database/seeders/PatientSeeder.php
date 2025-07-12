<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'name' => 'Jon Snow',
                'email' => 'jon.snow@gmail.com',
                'password' => bcrypt('jonsnow123'),
                'dni' => '19345211-7',
                'phone' => '56973456781',
                'address' => 'El Muro, Guardia de la Noche, Poniente',
            ],
            [
                'name' => 'Sansa Stark',
                'email' => 'sansa@gmail.com',
                'password' => bcrypt('sansa123'),
                'dni' => '16543211-9',
                'phone' => '56978945612',
                'address' => 'Invernalia, Norte, Poniente',
            ],
            [
                'name' => 'Eddard Stark',
                'email' => 'ned.stark@gmail.com',
                'password' => bcrypt('nedstark123'),
                'dni' => '14326789-2',
                'phone' => '56970011223',
                'address' => 'Invernalia, Norte, Poniente',
            ],
            [
                'name' => 'Daenerys Targaryen',
                'email' => 'daenerys@gmail.com',
                'password' => bcrypt('daenerys123'),
                'dni' => '14987654-3',
                'phone' => '56975643210',
                'address' => 'Meereen, Essos',
            ],
            [
                'name' => 'Robb Stark',
                'email' => 'robb.stark@gmail.com',
                'password' => bcrypt('robbstark123'),
                'dni' => '15432789-4',
                'phone' => '56973334455',
                'address' => 'Aguasdulces, Tridente, Poniente',
            ],
            [
                'name' => 'Cersei Lannister',
                'email' => 'cersei@gmail.com',
                'password' => bcrypt('cersei123'),
                'dni' => '12345678-9',
                'phone' => '56975558888',
                'address' => 'Desembarco del Rey, Poniente',
            ],
            [
                'name' => 'Jaime Lannister',
                'email' => 'jaime@gmail.com',
                'password' => bcrypt('jaime123'),
                'dni' => '13335577-k',
                'phone' => '56979991122',
                'address' => 'Roca Casterly, Poniente',
            ],
            [
                'name' => 'Theon Greyjoy',
                'email' => 'theon@gmail.com',
                'password' => bcrypt('theon1234'),
                'dni' => '16667788-4',
                'phone' => '56978889900',
                'address' => 'Pyke, Islas del Hierro',
            ],
            [
                'name' => 'Ygritte',
                'email' => 'ygritte@gmail.com',
                'password' => bcrypt('ygritte123'),
                'dni' => '15554321-1',
                'phone' => '56974445566',
                'address' => 'Más allá del Muro, Tierras de los Salvajes',
            ],
            [
                'name' => 'Tormund Giantsbane',
                'email' => 'tormund@gmail.com',
                'password' => bcrypt('tormund123'),
                'dni' => '16789012-5',
                'phone' => '56978887766',
                'address' => 'Tierras del Norte Salvaje',
            ],
        ];
        foreach ($patients as $patientData) {
            $patient = User::factory()->create($patientData);
            $patient->assignRole('Paciente');
        }
    }
}
