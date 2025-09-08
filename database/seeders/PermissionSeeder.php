<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

// C61: Roles y permisos
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir los distintos permisos
        $permissions = [
            'access_dashboard',

            'create_role',
            'read_role',
            'update_role',
            'delete_role',

            'create_user',
            'read_user',
            'update_user',
            'delete_user',

            'read_paciente',
            'update_paciente',

            'read_doctor',
            'update_doctor',

            'create_appointment',
            'read_appointment',
            'update_appointment',
            'delete_appointment',

            'read_calendar',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
