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
    // public function run(): void
    // {
    // User::factory(10)->create();

    // User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
    // }
    public function run(): void
    {
        $this->call([
            // Paramétricas
            ParamRolSeeder::class,
            ParamCarreraSeeder::class,
            ParamTurnoSeeder::class,
            ParamAulaSeeder::class,
            ParamMateriaSeeder::class,
            ParamSemestreSeeder::class,

            // Usuarios con roles
            RolesSeeder::class,

            // Estudiantes
            EstudianteSeeder::class,
        ]);
    }
}
