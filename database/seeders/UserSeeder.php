<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Maximiliano Gallegos',
                'email' => 'maxi@gmail.com',
                'password' => bcrypt('maxi1234'),
                'dni' => '20345267-k',
                'phone' => '56910206979',
                'address' => 'Calle Falsa 123, Gran Capital',
            ],
            [
                'name' => 'José Alarcón',
                'email' => 'jose@gmail.com',
                'password' => bcrypt('jose1234'),
                'dni' => '14443200-3',
                'phone' => '56920234790',
                'address' => 'Avenida Siempre Viva 456, San Luis',
            ],
            [
                'name' => 'Sandor Clegane',
                'email' => 'sandor@gmail.com',
                'password' => bcrypt('sandor1234'),
                'dni' => '14563210-k',
                'phone' => '56970234712',
                'address' => 'Tierras del Oeste, Poniente',
            ],
            [
                'name' => 'Tyrion Lannister',
                'email' => 'tyrion@gmail.com',
                'password' => bcrypt('tyrion1234'),
                'dni' => '16003212-8',
                'phone' => '56980145621',
                'address' => 'Roca Casterly, Poniente',
            ],
            [
                'name' => 'Jeor Mormont',
                'email' => 'jeor@gmail.com',
                'password' => bcrypt('jeorn1234'),
                'dni' => '11603752-k',
                'phone' => '56945567223',
                'address' => 'Isla del Oso, Poniente',
            ],
            [
                'name' => 'Samwell Tarly',
                'email' => 'sam@gmail.com',
                'password' => bcrypt('sam12345'),
                'dni' => '18782354-2',
                'phone' => '56974275888',
                'address' => 'Colina Cuerno, Dominio, Poniente',
            ],
            [
                'name' => 'Arya Stark',
                'email' => 'arya@gmail.com',
                'password' => bcrypt('arya1234'),
                'dni' => '18872354-1',
                'phone' => '56974123654',
                'address' => 'Invernalia, Norte, Poniente',
            ],
            [
                'name' => 'Brienne de Tarth',
                'email' => 'brienne@gmail.com',
                'password' => bcrypt('brienne1234'),
                'dni' => '17788821-k',
                'phone' => '56974523688',
                'address' => 'Isla de Tarth, Tierras de la Tormenta, Poniente',
            ],
            [
                'name' => 'Davos Seaworth',
                'email' => 'davos@gmail.com',
                'password' => bcrypt('davos1234'),
                'dni' => '15721152-6',
                'phone' => '56974115962',
                'address' => 'Puerto Blanco, Norte, Poniente',
            ],
            [
                'name' => 'Catelyn Stark',
                'email' => 'catelyn@gmail.com',
                'password' => bcrypt('catelyn1234'),
                'dni' => '14600122-9',
                'phone' => '56974222222',
                'address' => 'Invernalia, Norte, Poniente',
            ],
            [
                'name' => 'Petyr Baelish',
                'email' => 'petyr@gmail.com',
                'password' => bcrypt('petyr1234'),
                'dni' => '15684423-4',
                'phone' => '56976543210',
                'address' => 'Valle de Arryn, Poniente',
            ],
            [
                'name' => 'Stannis Baratheon',
                'email' => 'stannis@gmail.com',
                'password' => bcrypt('stannis1234'),
                'dni' => '16879012-3',
                'phone' => '56973123123',
                'address' => 'Rocadragón, Poniente',
            ],
            [
                'name' => 'Melisandre',
                'email' => 'melisandre@gmail.com',
                'password' => bcrypt('melisandre123'),
                'dni' => '17236458-k',
                'phone' => '56979002424',
                'address' => 'Asshai, Essos',
            ],
            [
                'name' => 'Oberyn Martell',
                'email' => 'oberyn@gmail.com',
                'password' => bcrypt('oberyn1234'),
                'dni' => '14325879-6',
                'phone' => '56979876543',
                'address' => 'Lanza del Sol, Dorne',
            ],
            [
                'name' => 'Jorah Mormont',
                'email' => 'jorah@gmail.com',
                'password' => bcrypt('jorah1234'),
                'dni' => '13456789-k',
                'phone' => '56979998888',
                'address' => 'Isla del Oso, Poniente',
            ],
            [
                'name' => 'Missandei',
                'email' => 'missandei@gmail.com',
                'password' => bcrypt('missandei123'),
                'dni' => '13888888-2',
                'phone' => '56972345678',
                'address' => 'Naath, Essos',
            ],

        ];

        /* C28: Asignación de Rol a User con Laravel Permission */
        foreach ($users as $userData) {
            $user = User::factory()->create($userData);
            $user->assignRole('Doctor'); // Asignar rol de Doctor
        }
    }
}
