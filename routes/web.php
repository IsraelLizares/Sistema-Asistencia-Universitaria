
<?php

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Carreras
Route::get('/carrera', [CarreraController::class, 'index'])->name('carrera.index');
Route::get('/carrera/data', [CarreraController::class, 'data'])->name('carrera.data');
Route::post('/carrera', [CarreraController::class, 'store'])->name('carrera.store');
Route::post('/carrera/destroy/{id}', [CarreraController::class, 'destroy'])->name('carrera.destroy');
Route::get('/carrera/show/{id}', [CarreraController::class, 'show'])->name('carrera.show');
Route::post('/carrera/{id}', [CarreraController::class, 'update'])->name('carrera.update');

//Materias

Route::get('/materia', [MateriaController::class, 'index'])->name('materia.index');
Route::get('/materia/data', [MateriaController::class, 'data'])->name('materia.data');
Route::post('/materia', [MateriaController::class, 'store'])->name('materia.store');
Route::post('/materia/destroy/{id}', [MateriaController::class, 'destroy'])->name('materia.destroy');
Route::get('/materia/show/{id}', [MateriaController::class, 'show'])->name('materia.show');
Route::post('/materia/{id}', [MateriaController::class, 'update'])->name('materia.update');

//Estudiantes

Route::get('/estudiante', [EstudianteController::class, 'index'])->name('estudiante.index');
Route::get('/estudiante/data', [EstudianteController::class, 'data'])->name('estudiante.data');
Route::post('/estudiante', [EstudianteController::class, 'store'])->name('estudiante.store');
Route::post('/estudiante/destroy/{id}', [EstudianteController::class, 'destroy'])->name('estudiante.destroy');
Route::get('/estudiante/show/{id}', [EstudianteController::class, 'show'])->name('estudiante.show');
Route::post('/estudiante/{id}', [EstudianteController::class, 'update'])->name('estudiante.update');
