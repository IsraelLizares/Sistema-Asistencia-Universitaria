<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use App\Models\UserRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('docentes.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ap_paterno' => 'required|string|max:255',
            'ap_materno' => 'nullable|string|max:255',
            'ci' => 'required|string|unique:docentes,ci',
            'celular' => 'required|string|max:20',
            'email' => 'required|email|unique:docentes,email',
            'direccion' => 'nullable|string',
            'profesion' => 'nullable|string|max:255',
            'fecha_contratacion' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            // Crear usuario
            $user = User::create([
                'name' => $request->nombre . ' ' . $request->ap_paterno,
                'email' => $request->email,
                'password' => Hash::make('docente123'), // Password por defecto
            ]);

            // Asignar rol de docente (ID 3)
            UserRol::create([
                'id_user' => $user->id,
                'id_rol' => 3,
                'estado' => 1,
            ]);

            // Crear perfil de docente
            $docente = Docente::create([
                'id_user' => $user->id,
                'nombre' => $request->nombre,
                'ap_paterno' => $request->ap_paterno,
                'ap_materno' => $request->ap_materno,
                'ci' => $request->ci,
                'celular' => $request->celular,
                'email' => $request->email,
                'direccion' => $request->direccion,
                'profesion' => $request->profesion,
                'fecha_contratacion' => $request->fecha_contratacion ?? now(),
                'estado' => 1,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Docente creado correctamente. Password: docente123',
                'docente' => $docente,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear docente: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $docente = Docente::with('usuario')->findOrFail($id);
        return response()->json($docente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ap_paterno' => 'required|string|max:255',
            'ap_materno' => 'nullable|string|max:255',
            'ci' => 'required|string|unique:docentes,ci,' . $id,
            'celular' => 'required|string|max:20',
            'email' => 'required|email|unique:docentes,email,' . $id,
            'direccion' => 'nullable|string',
            'profesion' => 'nullable|string|max:255',
            'fecha_contratacion' => 'nullable|date',
        ]);

        $docente = Docente::findOrFail($id);
        $docente->update($request->all());

        // Actualizar email del usuario
        $docente->usuario->update(['email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'Docente actualizado correctamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $docente = Docente::findOrFail($id);
        $docente->update(['estado' => 0]);

        return response()->json([
            'success' => true,
            'message' => 'Docente eliminado correctamente',
        ]);
    }

    /**
     * Obtener datos para DataTable
     */
    public function data()
    {
        $docentes = Docente::where('estado', 1)
            ->get()
            ->map(function($docente) {
                return [
                    'id' => $docente->id,
                    'nombre' => $docente->nombre,
                    'ap_paterno' => $docente->ap_paterno,
                    'ap_materno' => $docente->ap_materno,
                    'nombre_completo' => $docente->nombre . ' ' . $docente->ap_paterno . ' ' . ($docente->ap_materno ?? ''),
                    'ci' => $docente->ci,
                    'email' => $docente->email,
                    'celular' => $docente->celular,
                    'direccion' => $docente->direccion,
                    'profesion' => $docente->profesion
                ];
            });
        return response()->json(['data' => $docentes]);
    }

    /**
     * Obtener lista simple para selects
     */
    public function lista()
    {
        $docentes = Docente::where('estado', 1)
            ->select('id', 'nombre', 'ap_paterno', 'ap_materno')
            ->get()
            ->map(function($d) {
                return [
                    'id' => $d->id,
                    'nombre_completo' => $d->nombre . ' ' . $d->ap_paterno . ' ' . ($d->ap_materno ?? '')
                ];
            });
        return response()->json($docentes);
    }
}
