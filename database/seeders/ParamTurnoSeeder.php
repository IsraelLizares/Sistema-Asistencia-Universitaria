<?php

namespace Database\Seeders;

use App\Models\ParamTurno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParamTurnoSeeder extends Seeder
{
    public function run()
    {
        $turnos = [
            ['nombre_turno' => 'Mañana', 'hora_inicio' => '08:00:00', 'hora_fin' => '12:30:00', 'dias' => 'Lunes,Martes,Miércoles,Jueves,Viernes', 'estado' => 1],
            ['nombre_turno' => 'Noche', 'hora_inicio' => '19:00:00', 'hora_fin' => '22:30:00', 'dias' => 'Lunes,Martes,Miércoles,Jueves,Viernes,Sábado', 'estado' => 1],
        ];

        foreach ($turnos as $turno) {
            ParamTurno::create($turno);
        }
    }
}
