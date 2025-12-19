<?php

namespace App\Http\Controllers;

use App\Models\ParamMateria;
use App\Models\ParamSemestre;
use App\Models\ParamTurno;
use App\Models\ParamAula;
use App\Models\ParamCarrera;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    /**
     * Obtener lista de materias para select
     */
    public function materias()
    {
        $materias = ParamMateria::where('estado', 1)
            ->select('id', 'nombre_materia', 'codigo_materia')
            ->orderBy('nombre_materia')
            ->get();
        return response()->json($materias);
    }

    /**
     * Obtener lista de semestres para select
     */
    public function semestres()
    {
        $semestres = ParamSemestre::where('estado', 1)
            ->select('id', 'nombre_semestre', 'fecha_inicio', 'fecha_fin')
            ->orderBy('fecha_inicio', 'desc')
            ->get();
        return response()->json($semestres);
    }

    /**
     * Obtener lista de turnos para select
     */
    public function turnos()
    {
        $turnos = ParamTurno::where('estado', 1)
            ->select('id', 'nombre_turno', 'hora_inicio', 'hora_fin')
            ->orderBy('nombre_turno')
            ->get();
        return response()->json($turnos);
    }

    /**
     * Obtener lista de aulas para select
     */
    public function aulas()
    {
        $aulas = ParamAula::where('estado', 1)
            ->select('id', 'codigo_aula', 'capacidad', 'tipo')
            ->orderBy('codigo_aula')
            ->get();
        return response()->json($aulas);
    }

    /**
     * Obtener lista de carreras para select
     */
    public function carreras()
    {
        $carreras = ParamCarrera::where('estado', 1)
            ->select('id', 'nombre_carrera', 'codigo_carrera')
            ->orderBy('nombre_carrera')
            ->get();
        return response()->json($carreras);
    }
}
