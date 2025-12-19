<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Docente;
use App\Models\ParamMateria;
use App\Models\ParamSemestre;
use App\Models\ParamTurno;
use App\Models\ParamAula;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::where('estado', 1)->get();
        $materias = ParamMateria::where('estado', 1)->get();
        $semestres = ParamSemestre::where('estado', 1)->get();
        $turnos = ParamTurno::where('estado', 1)->get();
        $aulas = ParamAula::where('estado', 1)->get();

        return view('grupos.index', compact('docentes', 'materias', 'semestres', 'turnos', 'aulas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_materia' => 'required|exists:param_materia,id',
            'id_docente' => 'required|exists:docentes,id',
            'id_semestre' => 'required|exists:param_semestre,id',
            'id_turno' => 'required|exists:param_turno,id',
            'id_aula' => 'required|exists:param_aula,id',
        ]);

        $grupo = Grupo::create([
            'id_materia' => $request->id_materia,
            'id_docente' => $request->id_docente,
            'id_semestre' => $request->id_semestre,
            'id_turno' => $request->id_turno,
            'id_aula' => $request->id_aula,
            'estado' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Grupo creado correctamente',
            'grupo' => $grupo,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $grupo = Grupo::with(['materia', 'docente', 'semestre', 'turno', 'aula'])
            ->findOrFail($id);

        return response()->json($grupo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_materia' => 'required|exists:param_materia,id',
            'id_docente' => 'required|exists:docentes,id',
            'id_semestre' => 'required|exists:param_semestre,id',
            'id_turno' => 'required|exists:param_turno,id',
            'id_aula' => 'required|exists:param_aula,id',
        ]);

        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Grupo actualizado correctamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->update(['estado' => 0]);

        return response()->json([
            'success' => true,
            'message' => 'Grupo eliminado correctamente',
        ]);
    }

    /**
     * Obtener datos para DataTable
     */
    public function data()
    {
        $grupos = Grupo::with(['materia', 'docente', 'semestre', 'turno', 'aula'])
            ->where('estado', 1)
            ->get()
            ->map(function($grupo) {
                return [
                    'id' => $grupo->id,
                    'materia_nombre' => $grupo->materia->nombre_materia ?? 'N/A',
                    'docente_nombre' => ($grupo->docente->nombre ?? '') . ' ' . ($grupo->docente->ap_paterno ?? ''),
                    'semestre_nombre' => $grupo->semestre->nombre_semestre ?? 'N/A',
                    'turno_nombre' => $grupo->turno->nombre_turno ?? 'N/A',
                    'aula_nombre' => $grupo->aula->codigo_aula ?? 'N/A',
                    'id_materia' => $grupo->id_materia,
                    'id_docente' => $grupo->id_docente,
                    'id_semestre' => $grupo->id_semestre,
                    'id_turno' => $grupo->id_turno,
                    'id_aula' => $grupo->id_aula
                ];
            });
        return response()->json(['data' => $grupos]);
    }

    /**
     * Obtener lista simple de grupos para selects
     */
    public function lista()
    {
        $grupos = Grupo::with(['materia', 'semestre', 'docente', 'turno'])
            ->where('estado', 1)
            ->get()
            ->map(function($g) {
                return [
                    'id' => $g->id,
                    'nombre' => ($g->materia->nombre_materia ?? 'N/A') . ' - ' .
                               ($g->semestre->nombre_semestre ?? 'N/A') . ' - ' .
                               ($g->turno->nombre_turno ?? 'N/A'),
                    'materia_nombre' => $g->materia->nombre_materia ?? 'N/A',
                    'semestre_nombre' => $g->semestre->nombre_semestre ?? 'N/A',
                    'docente_nombre' => ($g->docente->nombre ?? '') . ' ' . ($g->docente->ap_paterno ?? '')
                ];
            });
        return response()->json($grupos);
    }
}
