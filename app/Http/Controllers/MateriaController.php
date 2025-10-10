<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Materia;
use App\Models\Carrera;

class MateriaController extends Controller
{
    public function index()
    {
        $carreras = Carrera::where('estado', true)->orderBy('nombre')->get(['id', 'nombre']);
        return view('materia.index', compact('carreras'));
    }

    public function data()
    {
        $materias = Materia::select('id', 'nombrea', 'codigo', 'id_carrera', 'estado')
            ->where('estado', true)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['data' => $materias]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombrea' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:materias,codigo',
            'id_carrera' => 'required|integer|exists:carrera,id',
        ]);
        $data['estado'] = true;
        $materia = Materia::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Materia creada correctamente',
            'materia' => $materia,
        ], 201);
    }

    public function show($id)
    {
        $materia = Materia::select('id', 'nombrea', 'codigo', 'id_carrera')
            ->where('estado', true)
            ->where('id', $id)
            ->first();
        return response()->json($materia);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombrea' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:materias,codigo,' . $id,
            'id_carrera' => 'required|integer|exists:carrera,id',
        ]);
        $materia = Materia::findOrFail($id);
        $materia->nombrea = $request->nombrea;
        $materia->codigo = $request->codigo;
        $materia->id_carrera = $request->id_carrera;
        $materia->save();
        return response()->json([
            'success' => true,
            'message' => 'Materia actualizada correctamente',
            'data' => $materia
        ]);
    }

    public function destroy($id)
    {
        $materia = Materia::find($id);
        if ($materia) {
            $materia->estado = false;
            $materia->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
