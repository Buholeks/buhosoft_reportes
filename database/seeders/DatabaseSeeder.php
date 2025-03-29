<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;  // Agregar esta línea
use Database\Seeders\RoleSeeder;  // Agregar esta línea

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class, // Asegúrate de tenerlo si lo usas
            RoleSeeder::class, // Agrega el Seeder de roles y permisos
        ]);
    }
}
