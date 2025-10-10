<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            // Ingeniería de Sistemas (id_carrera: 1)
            ['nombrea' => 'Programación I', 'codigo' => 'SIS101', 'id_carrera' => 1, 'estado' => true],
            ['nombrea' => 'Bases de Datos', 'codigo' => 'SIS102', 'id_carrera' => 1, 'estado' => true],
            ['nombrea' => 'Redes', 'codigo' => 'SIS103', 'id_carrera' => 1, 'estado' => true],
            ['nombrea' => 'Sistemas Operativos', 'codigo' => 'SIS104', 'id_carrera' => 1, 'estado' => true],
            // Administración de Empresas (id_carrera: 2)
            ['nombrea' => 'Administración General', 'codigo' => 'ADM201', 'id_carrera' => 2, 'estado' => true],
            ['nombrea' => 'Marketing', 'codigo' => 'ADM202', 'id_carrera' => 2, 'estado' => true],
            // Contabilidad (id_carrera: 3)
            ['nombrea' => 'Contabilidad Básica', 'codigo' => 'CON301', 'id_carrera' => 3, 'estado' => true],
            ['nombrea' => 'Auditoría', 'codigo' => 'CON302', 'id_carrera' => 3, 'estado' => true],
            // Derecho (id_carrera: 4)
            ['nombrea' => 'Derecho Civil', 'codigo' => 'DER401', 'id_carrera' => 4, 'estado' => true],
            // Psicología (id_carrera: 5)
            ['nombrea' => 'Psicología General', 'codigo' => 'PSI501', 'id_carrera' => 5, 'estado' => true],
        ];
        foreach ($materias as $materia) {
            Materia::create($materia);
        }
    }
}
