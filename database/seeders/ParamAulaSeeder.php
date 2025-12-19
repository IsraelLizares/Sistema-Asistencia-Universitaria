<?php

namespace Database\Seeders;

use App\Models\ParamAula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParamAulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $aulas = [
            ['codigo_aula' => 'A-01', 'capacidad' => 30, 'tipo' => 'teorica', 'estado' => 1],
            ['codigo_aula' => 'LAB-B02', 'capacidad' => 20, 'tipo' => 'laboratorio', 'estado' => 1],
            ['codigo_aula' => 'A-02', 'capacidad' => 40, 'tipo' => 'teorica', 'estado' => 1],
        ];

        foreach ($aulas as $aula) {
            ParamAula::create($aula);
        }
    }
}
