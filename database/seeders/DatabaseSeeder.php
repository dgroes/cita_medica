<?php

namespace Database\Seeders;

use App\Models\User;
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
            // UserSeeder::class,
        ]);

        $users = [
            [
                'name' => 'Maximiliano Gallegos',
                'email' => 'maxi@gmail.com',
                'password' => bcrypt('maxi1234'),
            ],
            [
                'name' => 'José Alarcón',
                'email' => 'jose@gmail.com',
                'password' => bcrypt('jose1234'),
            ]
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
    }
}
