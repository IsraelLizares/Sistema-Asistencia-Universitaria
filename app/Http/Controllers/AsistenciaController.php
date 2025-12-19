<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Sesion;
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Vista principal para registrar asistencia
        $user = Auth::user();

        // Si es docente, obtener sus grupos asignados
        $grupos = collect();
        if ($user->docente) {
            $grupos = Grupo::where('id_docente', $user->docente->id)
                ->where('estado', 1)
                ->with(['materia', 'semestre', 'turno', 'aula'])
                ->get();
        }

        return view('asistencias.index', compact('grupos'));
    }

    /**
     * Obtener estudiantes de un grupo para registrar asistencia
     */
    public function obtenerEstudiantes(Request $request)
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id',
            'fecha' => 'required|date',
        ]);

        $grupo = Grupo::with(['materia', 'semestre'])->findOrFail($request->id_grupo);

        // Verificar si ya existe una sesión para esta fecha y grupo
        $sesionExistente = Sesion::where('id_grupo', $request->id_grupo)
            ->whereDate('fecha', $request->fecha)
            ->first();

        // Obtener estudiantes inscritos en el grupo
        $estudiantes = Estudiante::whereHas('inscripciones', function ($query) use ($request) {
            $query->where('id_grupo', $request->id_grupo)
                ->where('estado', 1);
        })
        ->where('estado', 1)
        ->get();

        // Si existe sesión, cargar las asistencias con observaciones
        $asistencias = [];
        $observaciones = [];
        if ($sesionExistente) {
            $asistenciasData = Asistencia::where('id_sesion', $sesionExistente->id)
                ->get();

            foreach ($asistenciasData as $asist) {
                $asistencias[$asist->id_estudiante] = $asist->estado_asistencia;
                $observaciones[$asist->id_estudiante] = $asist->observacion;
            }
        }

        return response()->json([
            'estudiantes' => $estudiantes,
            'sesion_existente' => $sesionExistente ? true : false,
            'sesion_id' => $sesionExistente ? $sesionExistente->id : null,
            'asistencias' => $asistencias,
            'observaciones' => $observaciones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id',
            'fecha' => 'required|date',
            'tema' => 'nullable|string|max:255',
            'observacion_sesion' => 'nullable|string',
            'asistencias' => 'required|array|min:1',
            'asistencias.*.id_estudiante' => 'required|exists:estudiantes,id',
            'asistencias.*.estado_asistencia' => 'required|in:presente,ausente,justificado,tardanza',
            'asistencias.*.observacion' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Verificar si ya existe sesión para esta fecha y grupo
            $sesion = Sesion::where('id_grupo', $request->id_grupo)
                ->whereDate('fecha', $request->fecha)
                ->first();

            if ($sesion) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una sesión registrada para esta fecha y grupo. No se puede duplicar el registro.',
                ], 422);
            }

            // Verificar que todos los estudiantes pertenezcan al grupo
            $estudiantesGrupo = Inscripcion::where('id_grupo', $request->id_grupo)
                ->where('estado', 1)
                ->pluck('id_estudiante')
                ->toArray();

            foreach ($request->asistencias as $asistencia) {
                if (!in_array($asistencia['id_estudiante'], $estudiantesGrupo)) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Uno o más estudiantes no pertenecen al grupo seleccionado.',
                    ], 422);
                }
            }

            // Crear la sesión
            $sesion = Sesion::create([
                'id_grupo' => $request->id_grupo,
                'fecha' => $request->fecha,
                'tema' => $request->tema,
                'estado_sesion' => 'realizada',
                'tipo_sesion' => 'presencial',
                'observacion' => $request->observacion_sesion,
            ]);

            // Registrar asistencias
            foreach ($request->asistencias as $asistenciaData) {
                Asistencia::create([
                    'id_sesion' => $sesion->id,
                    'id_estudiante' => $asistenciaData['id_estudiante'],
                    'estado_asistencia' => $asistenciaData['estado_asistencia'],
                    'observacion' => $asistenciaData['observacion'] ?? null,
                    'id_usuario_registro' => Auth::id(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asistencia registrada correctamente.',
                'sesion_id' => $sesion->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencia: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sesion = Sesion::with([
            'grupo.materia',
            'grupo.semestre',
            'grupo.docente',
            'asistencias.estudiante'
        ])->findOrFail($id);

        return response()->json($sesion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tema' => 'nullable|string|max:255',
            'observacion_sesion' => 'nullable|string',
            'asistencias' => 'required|array',
            'asistencias.*.id_estudiante' => 'required|exists:estudiantes,id',
            'asistencias.*.estado_asistencia' => 'required|in:Presente,Ausente,Justificado,Tardanza',
            'asistencias.*.observacion' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $sesion = Sesion::findOrFail($id);

            // Actualizar sesión
            $sesion->update([
                'tema' => $request->tema,
                'observacion' => $request->observacion_sesion,
            ]);

            // Eliminar asistencias anteriores
            Asistencia::where('id_sesion', $sesion->id)->delete();

            // Registrar nuevas asistencias
            foreach ($request->asistencias as $asistenciaData) {
                Asistencia::create([
                    'id_sesion' => $sesion->id,
                    'id_estudiante' => $asistenciaData['id_estudiante'],
                    'estado_asistencia' => $asistenciaData['estado_asistencia'],
                    'observacion' => $asistenciaData['observacion'] ?? null,
                    'id_usuario_registro' => Auth::id(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asistencia actualizada correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar asistencia: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Consultar asistencia de un estudiante
     */
    public function miAsistencia()
    {
        $user = Auth::user();

        if (!$user->estudiante) {
            abort(403, 'No tienes un perfil de estudiante asociado.');
        }

        $estudiante = $user->estudiante;

        // Obtener asistencias del estudiante
        $asistencias = Asistencia::where('id_estudiante', $estudiante->id)
            ->with(['sesion.grupo.materia', 'sesion.grupo.semestre'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('asistencias.mi-asistencia', compact('estudiante', 'asistencias'));
    }

    /**
     * Obtener datos para DataTable
     */
    public function data(Request $request)
    {
        $query = Sesion::with(['grupo.materia', 'grupo.semestre', 'grupo.docente']);

        // Si es docente, filtrar solo sus grupos
        $user = Auth::user();
        if ($user->docente) {
            $query->whereHas('grupo', function ($q) use ($user) {
                $q->where('id_docente', $user->docente->id);
            });
        }

        $sesiones = $query->orderBy('fecha', 'desc')->get();

        return datatables()->of($sesiones)
            ->addColumn('materia', function ($sesion) {
                return $sesion->grupo->materia->materia ?? 'N/A';
            })
            ->addColumn('semestre', function ($sesion) {
                return $sesion->grupo->semestre->semestre ?? 'N/A';
            })
            ->addColumn('docente', function ($sesion) {
                return $sesion->grupo->docente->nombre . ' ' . $sesion->grupo->docente->ap_paterno;
            })
            ->addColumn('total_estudiantes', function ($sesion) {
                return $sesion->asistencias()->count();
            })
            ->addColumn('presentes', function ($sesion) {
                return $sesion->asistencias()->where('estado_asistencia', 'Presente')->count();
            })
            ->addColumn('ausentes', function ($sesion) {
                return $sesion->asistencias()->where('estado_asistencia', 'Ausente')->count();
            })
            ->make(true);
    }
}
