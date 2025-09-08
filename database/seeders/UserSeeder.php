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
            // Usuarios reservados para Doctores (id:1 - id:9)
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

            // Usuarios reservada para Pacientes (id:10 - id:24)
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

        /* C28: Asignación de Rol a User con Laravel Permission */
        /* C62: Restricción de rutas */
        foreach ($users as $index => $userData) {
            $user = User::factory()->create($userData);

            // Admin primero
            if ($user->email === 'davos@gmail.com') {
                $user->assignRole('Admin');
                continue;
            }

            if ($index < 9) {
                $user->assignRole('Doctor');
            } else {
                $user->assignRole('Paciente');
            }
        }
    }
}
