<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    /* C21: Semillas (Role) */
    public function run(): void
    {
        // C61: Roles y permisos
        $roles = [
            'Paciente' => [
                'access_dashboard',
                'create_appointment',
                'read_appointment',
                'read_calendar',
            ],
            'Doctor' => [
                'access_dashboard',
                'read_appointment',
                'update_appointment',
                'delete_appointment',
                'read_calendar',
            ],
            'Recepcionista' => [
                'access_dashboard',

                'create_user',
                'read_user',
                'update_user',
                'delete_user',

                'read_patient',
                'update_patient',

                'read_doctor',
                'update_doctor',

                'create_appointment',
                'read_appointment',
                'update_appointment',
                'delete_appointment',

                'read_calendar',

            ],
        ];

        // Crear roles y asignar permisos
        foreach ($roles as $role => $permissions) {
            Role::create([
                'name' => $role
            ])
            ->givePermissionTo($permissions);
        }

        //Rol admin con todos los permisos
        Role::create([
            'name'=> 'Admin',
        ])->givePermissionTo(Permission::all());
    }
}
