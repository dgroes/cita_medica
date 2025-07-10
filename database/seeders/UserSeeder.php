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
            ]
        ];

        /* C28: Asignación de Rol a User con Laravel Permission */
        foreach ($users as $userData) {
            $user = User::factory()->create($userData);
            $user->assignRole('Doctor'); // Asignar rol de Doctor
        }
    }
}
