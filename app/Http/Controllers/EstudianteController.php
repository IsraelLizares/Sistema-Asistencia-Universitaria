<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\ParamCarrera;
use App\Models\User;
use App\Models\UserRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    public function index()
    {
        $carreras = ParamCarrera::where('estado', true)->orderBy('nombre_carrera')->get(['id', 'nombre_carrera as nombre']);
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
            'ci' => 'required|string|max:20|unique:estudiantes,ci',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|string|max:100|email|unique:estudiantes,email|unique:users,email',
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'id_carrera' => 'required|integer|exists:param_carrera,id',
            'turno' => 'required|in:mañana,noche',
            'matricula' => 'required|string|max:30|unique:estudiantes,matricula',
        ]);

        try {
            DB::beginTransaction();

            // Crear usuario
            $user = User::create([
                'name' => $data['nombre'] . ' ' . $data['ap_paterno'],
                'email' => $data['email'],
                'password' => Hash::make($data['ci']), // CI como contraseña por defecto
            ]);

            // Asignar rol de estudiante (id = 5)
            UserRol::create([
                'id_user' => $user->id,
                'id_rol' => 5
            ]);

            // Crear estudiante
            $data['id_user'] = $user->id;
            $data['estado'] = true;
            $estudiante = Estudiante::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estudiante creado correctamente',
                'estudiante' => $estudiante,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear estudiante: ' . $e->getMessage()
            ], 500);
        }
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
        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'ap_paterno' => 'required|string|max:50',
            'ap_materno' => 'nullable|string|max:50',
            'ci' => 'required|string|max:20|unique:estudiantes,ci,' . $id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|string|max:100|email|unique:estudiantes,email,' . $id . '|unique:users,email,' . $estudiante->id_user,
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'id_carrera' => 'required|integer|exists:param_carrera,id',
            'turno' => 'required|in:mañana,noche',
            'matricula' => 'required|string|max:30|unique:estudiantes,matricula,' . $id,
        ]);

        try {
            DB::beginTransaction();

            // Actualizar usuario asociado
            $user = User::findOrFail($estudiante->id_user);
            $user->name = $request->nombre . ' ' . $request->ap_paterno;
            $user->email = $request->email;
            $user->save();

            // Actualizar estudiante
            $estudiante->fill($request->all());
            $estudiante->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estudiante actualizado correctamente',
                'data' => $estudiante
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar estudiante: ' . $e->getMessage()
            ], 500);
        }
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
