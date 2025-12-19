<?php

namespace Database\Seeders;

use App\Models\ParamSemestre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParamSemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $semestres = [
            ['nombre_semestre' => 'Semestre I', 'fecha_inicio' => '2025-03-01', 'fecha_fin' => '2025-07-31', 'estado' => 1],
            ['nombre_semestre' => 'Semestre II', 'fecha_inicio' => '2025-08-01', 'fecha_fin' => '2025-12-31', 'estado' => 1],
        ];

        foreach ($semestres as $sem) {
            ParamSemestre::create($sem);
        }
    }
}
