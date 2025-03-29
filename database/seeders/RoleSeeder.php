<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
   
        // Crear permisos
        $permissions = [
            'ver usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver productos',
            'editar productos',
            'eliminar productos'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $viewer = Role::create(['name' => 'viewer']);

        // Asignar permisos a los roles
        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['ver usuarios', 'editar usuarios']);
        $viewer->givePermissionTo(['ver usuarios']);

        // Asignar rol de Admin al primer usuario (ID 1)
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
