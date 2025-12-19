<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Sesion;
use App\Models\Grupo;
use App\Models\Estudiante;
use App\Models\ParamMateria;
use App\Models\ParamSemestre;
use App\Models\ParamCarrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Vista principal de reportes
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener datos para filtros
        $carreras = ParamCarrera::where('estado', 1)->get();
        $materias = ParamMateria::where('estado', 1)->get();
        $semestres = ParamSemestre::where('estado', 1)->get();
        $estudiantes = Estudiante::where('estado', 1)
            ->orderBy('nombre')
            ->orderBy('ap_paterno')
            ->get();

        // Si es docente, obtener solo sus materias
        if ($user->docente) {
            $materias = ParamMateria::whereHas('grupos', function ($query) use ($user) {
                $query->where('id_docente', $user->docente->id);
            })->where('estado', 1)->get();
        }

        return view('reportes.index', compact('carreras', 'materias', 'semestres', 'estudiantes'));
    }

    /**
     * Reporte general de asistencias (vista)
     */
    public function reporteGeneral(Request $request)
    {
        $query = Sesion::with(['grupo.materia', 'grupo.semestre', 'grupo.docente', 'asistencias']);

        // Filtros
        if ($request->fecha_inicio) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->fecha_fin) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        if ($request->id_materia) {
            $query->whereHas('grupo', function ($q) use ($request) {
                $q->where('id_materia', $request->id_materia);
            });
        }

        if ($request->id_semestre) {
            $query->whereHas('grupo', function ($q) use ($request) {
                $q->where('id_semestre', $request->id_semestre);
            });
        }

        // Si es docente, filtrar solo sus grupos
        $user = Auth::user();
        if ($user->docente) {
            $query->whereHas('grupo', function ($q) use ($user) {
                $q->where('id_docente', $user->docente->id);
            });
        }

        $sesiones = $query->orderBy('fecha', 'desc')->get();

        return view('reportes.general', compact('sesiones'));
    }

    /**
     * Reporte por estudiante
     */
    public function reportePorEstudiante(Request $request)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id',
        ]);

        $estudiante = Estudiante::with('carrera')->findOrFail($request->id_estudiante);

        $asistencias = Asistencia::where('id_estudiante', $request->id_estudiante)
            ->with(['sesion.grupo.materia', 'sesion.grupo.semestre'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Estadísticas
        $total = $asistencias->count();
        $presentes = $asistencias->where('estado_asistencia', 'presente')->count();
        $ausentes = $asistencias->where('estado_asistencia', 'ausente')->count();
        $justificadas = $asistencias->where('estado_asistencia', 'justificado')->count();
        $tardanzas = $asistencias->where('estado_asistencia', 'tardanza')->count();

        $porcentajeAsistencia = $total > 0 ? round(($presentes / $total) * 100, 2) : 0;

        return view('reportes.por-estudiante', compact(
            'estudiante',
            'asistencias',
            'total',
            'presentes',
            'ausentes',
            'justificadas',
            'tardanzas',
            'porcentajeAsistencia'
        ));
    }

    /**
     * Reporte por materia
     */
    public function reportePorMateria(Request $request)
    {
        $request->validate([
            'id_materia' => 'required|exists:param_materia,id',
            'id_semestre' => 'nullable|exists:param_semestre,id',
        ]);

        $materia = ParamMateria::findOrFail($request->id_materia);
        $semestre = $request->id_semestre ? ParamSemestre::findOrFail($request->id_semestre) : null;

        // Obtener grupos de la materia
        $query = Grupo::where('id_materia', $request->id_materia)
            ->where('estado', 1)
            ->with(['docente', 'semestre', 'turno']);

        if ($request->id_semestre) {
            $query->where('id_semestre', $request->id_semestre);
        }

        $grupos = $query->get();

        // Obtener sesiones de estos grupos
        $sesiones = Sesion::whereIn('id_grupo', $grupos->pluck('id'))
            ->with(['asistencias.estudiante'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('reportes.por-materia', compact('materia', 'semestre', 'grupos', 'sesiones'));
    }

    /**
     * Generar PDF - Reporte General
     */
    public function generarPdfGeneral(Request $request)
    {
        $query = Sesion::with(['grupo.materia', 'grupo.semestre', 'grupo.docente', 'asistencias']);

        // Aplicar filtros
        if ($request->fecha_inicio) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->fecha_fin) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        if ($request->id_materia) {
            $query->whereHas('grupo', function ($q) use ($request) {
                $q->where('id_materia', $request->id_materia);
            });
        }

        $user = Auth::user();
        if ($user->docente) {
            $query->whereHas('grupo', function ($q) use ($user) {
                $q->where('id_docente', $user->docente->id);
            });
        }

        $sesiones = $query->orderBy('fecha', 'desc')->get();

        $pdf = Pdf::loadView('reportes.pdf.general', compact('sesiones'));
        return $pdf->download('reporte-asistencias-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generar PDF - Reporte por Estudiante
     */
    public function generarPdfEstudiante(Request $request)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id',
        ]);

        $estudiante = Estudiante::with('carrera')->findOrFail($request->id_estudiante);

        $asistencias = Asistencia::where('id_estudiante', $request->id_estudiante)
            ->with(['sesion.grupo.materia', 'sesion.grupo.semestre'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Estadísticas
        $total = $asistencias->count();
        $presentes = $asistencias->where('estado_asistencia', 'presente')->count();
        $ausentes = $asistencias->where('estado_asistencia', 'ausente')->count();
        $justificadas = $asistencias->where('estado_asistencia', 'justificado')->count();
        $porcentajeAsistencia = $total > 0 ? round(($presentes / $total) * 100, 2) : 0;

        $pdf = Pdf::loadView('reportes.pdf.estudiante', compact(
            'estudiante',
            'asistencias',
            'total',
            'presentes',
            'ausentes',
            'justificadas',
            'porcentajeAsistencia'
        ));

        return $pdf->download('reporte-estudiante-' . $estudiante->matricula . '.pdf');
    }

    /**
     * Datos para Chart.js - Dashboard General
     */
    public function datosGraficoGeneral()
    {
        $user = Auth::user();

        // Asistencias de los últimos 7 días
        $fechaInicio = Carbon::now()->subDays(6);

        $query = Sesion::whereDate('fecha', '>=', $fechaInicio)
            ->with('asistencias');

        if ($user->docente) {
            $query->whereHas('grupo', function ($q) use ($user) {
                $q->where('id_docente', $user->docente->id);
            });
        }

        $sesiones = $query->get();

        // Preparar datos para el gráfico
        $fechas = [];
        $presentes = [];
        $ausentes = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i);
            $fechas[] = $fecha->format('d/m');

            $sesionesDia = $sesiones->where('fecha', $fecha->format('Y-m-d'));
            $presentesDia = 0;
            $ausentesDia = 0;

            foreach ($sesionesDia as $sesion) {
                $presentesDia += $sesion->asistencias->where('estado_asistencia', 'presente')->count();
                $ausentesDia += $sesion->asistencias->where('estado_asistencia', 'ausente')->count();
            }

            $presentes[] = $presentesDia;
            $ausentes[] = $ausentesDia;
        }

        return response()->json([
            'labels' => $fechas,
            'presentes' => $presentes,
            'ausentes' => $ausentes,
        ]);
    }

    /**
     * Datos para Chart.js - Estadísticas por Materia
     */
    public function datosGraficoPorMateria(Request $request)
    {
        $request->validate([
            'id_materia' => 'required|exists:param_materia,id',
        ]);

        $grupos = Grupo::where('id_materia', $request->id_materia)
            ->where('estado', 1)
            ->get();

        $sesiones = Sesion::whereIn('id_grupo', $grupos->pluck('id'))
            ->with('asistencias')
            ->get();

        $totalAsistencias = 0;
        $totalPresentes = 0;
        $totalAusentes = 0;
        $totalJustificadas = 0;
        $totalTardanzas = 0;

        foreach ($sesiones as $sesion) {
            $totalAsistencias += $sesion->asistencias->count();
            $totalPresentes += $sesion->asistencias->where('estado_asistencia', 'presente')->count();
            $totalAusentes += $sesion->asistencias->where('estado_asistencia', 'ausente')->count();
            $totalJustificadas += $sesion->asistencias->where('estado_asistencia', 'justificado')->count();
            $totalTardanzas += $sesion->asistencias->where('estado_asistencia', 'tardanza')->count();
        }

        return response()->json([
            'labels' => ['Presente', 'Ausente', 'Justificado', 'Tardanza'],
            'data' => [$totalPresentes, $totalAusentes, $totalJustificadas, $totalTardanzas],
        ]);
    }

    /**
     * Datos para Chart.js - Top 10 Estudiantes con más faltas
     */
    public function datosGraficoTopFaltas()
    {
        $estudiantesConFaltas = DB::table('asistencias')
            ->join('estudiantes', 'asistencias.id_estudiante', '=', 'estudiantes.id')
            ->select(
                'estudiantes.id',
                DB::raw("CONCAT(estudiantes.nombre, ' ', estudiantes.ap_paterno) as nombre_completo"),
                DB::raw('COUNT(*) as total_faltas')
            )
            ->where('asistencias.estado_asistencia', 'ausente')
            ->groupBy('estudiantes.id', 'estudiantes.nombre', 'estudiantes.ap_paterno')
            ->orderByDesc('total_faltas')
            ->limit(10)
            ->get();

        return response()->json([
            'labels' => $estudiantesConFaltas->pluck('nombre_completo'),
            'data' => $estudiantesConFaltas->pluck('total_faltas'),
        ]);
    }

    /**
     * Buscar estudiantes (para autocomplete)
     */
    public function buscarEstudiantes(Request $request)
    {
        $query = Estudiante::where('estado', 1);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'ilike', '%' . $request->search . '%')
                  ->orWhere('ap_paterno', 'ilike', '%' . $request->search . '%')
                  ->orWhere('ap_materno', 'ilike', '%' . $request->search . '%')
                  ->orWhere('matricula', 'ilike', '%' . $request->search . '%')
                  ->orWhere('ci', 'ilike', '%' . $request->search . '%');
            });
        }

        $estudiantes = $query->limit(10)->get();

        return response()->json($estudiantes->map(function ($estudiante) {
            return [
                'id' => $estudiante->id,
                'text' => $estudiante->nombre . ' ' . $estudiante->ap_paterno . ' - ' . $estudiante->matricula,
            ];
        }));
    }
}
