<?php

namespace Database\Seeders;

use App\Models\ParamRol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParamRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            ['rol' => 'Administrador', 'estado' => 1],
            ['rol' => 'Admin Parámetros', 'estado' => 1],
            ['rol' => 'Docente', 'estado' => 1],
            ['rol' => 'Coordinador', 'estado' => 1],
            ['rol' => 'Estudiante', 'estado' => 1],
        ];

        foreach ($roles as $rol) {
            ParamRol::updateOrCreate(
                ['rol' => $rol['rol']],
                $rol
            );
        }

        $this->command->info(count($roles) . ' Roles insertados correctamente');
    }
}
