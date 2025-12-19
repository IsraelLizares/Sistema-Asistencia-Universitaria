<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\ParamCarrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class InscripcionController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['materia', 'semestre', 'docente'])->where('estado', 1)->get();
        $carreras = ParamCarrera::select('id', 'nombre_carrera as nombre')->where('estado', 1)->get();
        return view('inscripcion.index', compact('grupos', 'carreras'));
    }

    public function data()
    {
        $inscripciones = Inscripcion::with(['estudiante.carrera', 'grupo.materia', 'grupo.semestre'])
            ->where('estado', 1)
            ->get()
            ->map(function($inscripcion) {
                return [
                    'id' => $inscripcion->id,
                    'estudiante_nombre' => $inscripcion->estudiante->nombre . ' ' . $inscripcion->estudiante->ap_paterno . ' ' . ($inscripcion->estudiante->ap_materno ?? ''),
                    'materia_nombre' => $inscripcion->grupo->materia->nombre_materia ?? 'N/A',
                    'semestre_nombre' => $inscripcion->grupo->semestre->nombre_semestre ?? 'N/A',
                    'carrera_nombre' => $inscripcion->estudiante->carrera->nombre_carrera ?? 'N/A',
                    'id_estudiante' => $inscripcion->id_estudiante,
                    'id_grupo' => $inscripcion->id_grupo
                ];
            });
        return response()->json(['data' => $inscripciones]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id',
            'id_grupo' => 'required|exists:grupos,id',
        ]);

        // Verificar si ya está inscrito
        $existe = Inscripcion::where('id_estudiante', $request->id_estudiante)
            ->where('id_grupo', $request->id_grupo)
            ->where('estado', 1)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'El estudiante ya está inscrito en este grupo'], 422);
        }

        $inscripcion = Inscripcion::create([
            'id_estudiante' => $request->id_estudiante,
            'id_grupo' => $request->id_grupo,
            'estado_inscripcion' => 'regular',
            'estado' => 1
        ]);
        return response()->json(['success' => 'Inscripción creada correctamente', 'data' => $inscripcion]);
    }

    public function show($id)
    {
        $inscripcion = Inscripcion::with(['estudiante', 'grupo'])->findOrFail($id);
        return response()->json($inscripcion);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id',
            'id_grupo' => 'required|exists:grupos,id',
        ]);

        $inscripcion = Inscripcion::findOrFail($id);

        // Verificar duplicados excluyendo el registro actual
        $existe = Inscripcion::where('id_estudiante', $request->id_estudiante)
            ->where('id_grupo', $request->id_grupo)
            ->where('estado', 1)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'El estudiante ya está inscrito en este grupo'], 422);
        }

        $inscripcion->update([
            'id_estudiante' => $request->id_estudiante,
            'id_grupo' => $request->id_grupo
        ]);
        return response()->json(['success' => 'Inscripción actualizada correctamente', 'data' => $inscripcion]);
    }

    public function destroy($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->update(['estado' => 0]);
        return response()->json(['success' => 'Inscripción eliminada correctamente']);
    }

    // Obtener estudiantes por carrera para el formulario
    public function estudiantes($id_carrera = null)
    {
        $query = Estudiante::with('carrera');

        if ($id_carrera) {
            $query->where('id_carrera', $id_carrera);
        }

        $estudiantes = $query->get();
        return response()->json($estudiantes);
    }
}
