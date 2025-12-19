<?php

namespace Database\Seeders;

use App\Models\ParamCarrera;
use App\Models\ParamMateria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParamMateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $materias = [
            ['nombre_materia' => 'Matemáticas I', 'codigo_materia' => 'MAT101', 'carrera_nombre' => 'Ingeniería de Sistemas', 'estado' => 1],
            ['nombre_materia' => 'Programación I', 'codigo_materia' => 'PROG101', 'carrera_nombre' => 'Ingeniería de Sistemas', 'estado' => 1],
            ['nombre_materia' => 'Contabilidad Básica', 'codigo_materia' => 'CON101', 'carrera_nombre' => 'Administración de Empresas', 'estado' => 1],
        ];

        foreach ($materias as $mat) {
            $carrera = ParamCarrera::where('nombre_carrera', $mat['carrera_nombre'])->first();
            if($carrera){
                ParamMateria::create([
                    'nombre_materia' => $mat['nombre_materia'],
                    'codigo_materia' => $mat['codigo_materia'],
                    'id_carrera' => $carrera->id,
                    'estado' => $mat['estado'],
                ]);
            }
        }
    }
}
