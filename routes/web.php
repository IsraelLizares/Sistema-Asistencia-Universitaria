
<?php

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ParamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ============================================
// RUTAS PROTEGIDAS CON MIDDLEWARE Y GATES
// ============================================

Route::middleware(['auth', 'coordinador'])->group(function () {
    Route::get('/inscripcion', [InscripcionController::class, 'index'])->name('inscripcion.index');
    Route::get('/inscripcion/data', [InscripcionController::class, 'data'])->name('inscripcion.data');
    Route::post('/inscripcion', [InscripcionController::class, 'store'])->name('inscripcion.store');
    Route::get('/inscripcion/show/{id}', [InscripcionController::class, 'show'])->name('inscripcion.show');
    Route::post('/inscripcion/{id}', [InscripcionController::class, 'update'])->name('inscripcion.update');
    Route::post('/inscripcion/destroy/{id}', [InscripcionController::class, 'destroy'])->name('inscripcion.destroy');
    Route::get('/inscripcion/estudiantes/{id_carrera?}', [InscripcionController::class, 'estudiantes'])->name('inscripcion.estudiantes');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/docente', [DocenteController::class, 'index'])->name('docente.index');
    Route::get('/docente/data', [DocenteController::class, 'data'])->name('docente.data');
    Route::get('/docente/lista', [DocenteController::class, 'lista'])->name('docente.lista');
    Route::post('/docente', [DocenteController::class, 'store'])->name('docente.store');
    Route::get('/docente/show/{id}', [DocenteController::class, 'show'])->name('docente.show');
    Route::post('/docente/{id}', [DocenteController::class, 'update'])->name('docente.update');
    Route::post('/docente/destroy/{id}', [DocenteController::class, 'destroy'])->name('docente.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/param/materias', [ParamController::class, 'materias'])->name('param.materias');
    Route::get('/param/semestres', [ParamController::class, 'semestres'])->name('param.semestres');
    Route::get('/param/turnos', [ParamController::class, 'turnos'])->name('param.turnos');
    Route::get('/param/aulas', [ParamController::class, 'aulas'])->name('param.aulas');
    Route::get('/param/carreras', [ParamController::class, 'carreras'])->name('param.carreras');
});

Route::middleware(['auth', 'coordinador'])->group(function () {
    Route::get('/estudiante', [EstudianteController::class, 'index'])->name('estudiante.index');
    Route::get('/estudiante/data', [EstudianteController::class, 'data'])->name('estudiante.data');
    Route::post('/estudiante', [EstudianteController::class, 'store'])->name('estudiante.store');
    Route::post('/estudiante/destroy/{id}', [EstudianteController::class, 'destroy'])->name('estudiante.destroy');
    Route::get('/estudiante/show/{id}', [EstudianteController::class, 'show'])->name('estudiante.show');
    Route::post('/estudiante/{id}', [EstudianteController::class, 'update'])->name('estudiante.update');
});

Route::middleware(['auth', 'docente'])->group(function () {
    Route::get('/grupo', [GrupoController::class, 'index'])->name('grupo.index');
    Route::get('/grupo/data', [GrupoController::class, 'data'])->name('grupo.data');
    Route::get('/grupo/lista', [GrupoController::class, 'lista'])->name('grupo.lista');
    Route::post('/grupo', [GrupoController::class, 'store'])->name('grupo.store');
    Route::get('/grupo/show/{id}', [GrupoController::class, 'show'])->name('grupo.show');
    Route::post('/grupo/{id}', [GrupoController::class, 'update'])->name('grupo.update');
    Route::post('/grupo/destroy/{id}', [GrupoController::class, 'destroy'])->name('grupo.destroy');
});

Route::middleware(['auth', 'docente'])->group(function () {
    Route::get('/asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::get('/asistencia/data', [AsistenciaController::class, 'data'])->name('asistencia.data');
    Route::post('/asistencia/estudiantes', [AsistenciaController::class, 'obtenerEstudiantes'])->name('asistencia.estudiantes');
    Route::post('/asistencia', [AsistenciaController::class, 'store'])->name('asistencia.store');
    Route::get('/asistencia/show/{id}', [AsistenciaController::class, 'show'])->name('asistencia.show');
    Route::post('/asistencia/{id}', [AsistenciaController::class, 'update'])->name('asistencia.update');
});

Route::middleware(['auth', 'estudiante'])->group(function () {
    Route::get('/mi-asistencia', [AsistenciaController::class, 'miAsistencia'])->name('mi-asistencia');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    Route::get('/reportes/general', [ReporteController::class, 'reporteGeneral'])->name('reportes.general');
    Route::get('/reportes/estudiante', [ReporteController::class, 'reportePorEstudiante'])->name('reportes.estudiante');
    Route::get('/reportes/materia', [ReporteController::class, 'reportePorMateria'])->name('reportes.materia');

    Route::get('/reportes/pdf/general', [ReporteController::class, 'generarPdfGeneral'])->name('reportes.pdf.general');
    Route::get('/reportes/pdf/estudiante', [ReporteController::class, 'generarPdfEstudiante'])->name('reportes.pdf.estudiante');

    Route::get('/reportes/graficos/general', [ReporteController::class, 'datosGraficoGeneral'])->name('reportes.graficos.general');
    Route::get('/reportes/graficos/materia', [ReporteController::class, 'datosGraficoPorMateria'])->name('reportes.graficos.materia');
    Route::get('/reportes/graficos/top-faltas', [ReporteController::class, 'datosGraficoTopFaltas'])->name('reportes.graficos.top-faltas');

    Route::get('/reportes/buscar-estudiantes', [ReporteController::class, 'buscarEstudiantes'])->name('reportes.buscar-estudiantes');
});
