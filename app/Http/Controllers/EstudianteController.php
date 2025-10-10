<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Carrera;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        $carreras = Carrera::where('estado', true)->orderBy('nombre')->get(['id', 'nombre']);
        return view('estudiante.index', compact('carreras'));
    }

    public function data()
    {
        $estudiantes = Estudiante::select('id', 'nombre', 'ap_paterno', 'ap_materno', 'ci', 'telefono', 'email', 'direccion', 'fecha_nacimiento', 'id_carrera', 'turno', 'matricula', 'estado')
            ->where('estado', true)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['data' => $estudiantes]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'ap_paterno' => 'required|string|max:50',
            'ap_materno' => 'nullable|string|max:50',
            'ci' => 'required|string|max:20|unique:estudiante,ci',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|string|max:100|email|unique:estudiante,email',
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'id_carrera' => 'required|integer|exists:carrera,id',
            'turno' => 'required|in:mañana,noche',
            'matricula' => 'required|string|max:30|unique:estudiante,matricula',
        ]);
        $data['estado'] = true;
        $estudiante = Estudiante::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Estudiante creado correctamente',
            'estudiante' => $estudiante,
        ], 201);
    }

    public function show($id)
    {
        $estudiante = Estudiante::select('id', 'nombre', 'ap_paterno', 'ap_materno', 'ci', 'telefono', 'email', 'direccion', 'fecha_nacimiento', 'id_carrera', 'turno', 'matricula')
            ->where('estado', true)
            ->where('id', $id)
            ->first();
    //         $estudiantes = Estudiante::join('carrera', 'estudiante.id_carrera', '=', 'carrera.id')
    // ->select('estudiantes.*', 'carreras.nombre as nombre_carrera')
    // ->get();
        return response()->json($estudiante);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ap_paterno' => 'required|string|max:50',
            'ap_materno' => 'nullable|string|max:50',
            'ci' => 'required|string|max:20|unique:estudiante,ci,' . $id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|string|max:100|email|unique:estudiante,email,' . $id,
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'id_carrera' => 'required|integer|exists:carrera,id',
            'turno' => 'required|in:mañana,noche',
            'matricula' => 'required|string|max:30|unique:estudiante,matricula,' . $id,
        ]);
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->fill($request->all());
        $estudiante->save();
        return response()->json([
            'success' => true,
            'message' => 'Estudiante actualizado correctamente',
            'data' => $estudiante
        ]);
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);
        if ($estudiante) {
            $estudiante->estado = false;
            $estudiante->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
