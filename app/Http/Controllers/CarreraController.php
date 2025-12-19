<?php

namespace App\Http\Controllers;

use App\Models\ParamCarrera;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CarreraController extends Controller
{
    public function index()
    {
        // $carreras = Carrera::select('id', 'nombre', 'descripcion', 'estado')
        //     ->where("estado", true)
        //     ->orderBy('id', 'desc')
        //     ->get();

        // // $carreras = Carrera::all();
        // return view('carrera.index', compact('carreras'));
        return view('carrera.index');
    }

    public function data()
    {
        $carreras = ParamCarrera::select('id', 'nombre', 'descripcion', 'estado')
            ->where('estado', true) // ✅ solo activos
            ->orderBy('id', 'desc') // ✅ orden descendente
            ->get();
        return response()->json(['data' => $carreras]);
    }

    public function store(Request $request)
    {
        // Validación mínima
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:100',
            // 'descripcion' => 'nullable|string|max:100',
            // 'precio_venta' => 'required|numeric|min:0',
            // 'cantidad_stock' => 'required|integer|min:0',
        ]);
        // Campos adicionales
        $data['estado'] = true; // activo por defecto
        // $data['categoria_id'] = 1; // ✅ categoría por defecto (provicional)
        $carrera = ParamCarrera::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Carerra creado correctamente',
            'carrera' => $carrera,
        ], 201);
    }

    public function show($id)
    {
        $carrera = ParamCarrera::select('id', 'nombre', 'descripcion')
            ->where('estado', true)
            ->where('id', $id)
            ->first();
        return response()->json($carrera);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // 'id_carrrera' => 'required|integer',
            // 'codigo_barras' => 'nullable|string|max:255',
            // 'precio_venta' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255',
        ]);
        $carrera = ParamCarrera::findOrFail($id);
        $carrera->nombre = $request->nombre;
        $carrera->descripcion = $request->descripcion;
        $carrera->save();
        return response()->json([
            'success' => true,
            'message' => 'Carrera actualizado correctamente',
            'data' => $carrera
        ]);
    }

    public function destroy($id)
    {
        $carrera = ParamCarrera::find($id);
        if ($carrera) {
            $carrera->estado = false;
            $carrera->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function pdf()
    {
        $productos = ParamCarrera::from('param_carrera as carreras')
            ->select(
                'carreras.id',
                'carreras.nombre_carrera',
                'tbl_categorias.descripcion as categoria',
                'productos.codigo_barras',
                'productos.precio_venta',
                'productos.cantidad_stock'
            )
            ->join('tbl_categorias', 'productos.categoria_id', '=', 'tbl_categorias.id')
            ->where('productos.estado', true)
            ->where('tbl_categorias.estado', true)
            ->orderBy('productos.id', 'desc')
            ->get();
        $pdf = Pdf::loadView('reportes.productos', compact('productos'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('lista-productos-' . now()->format('d-m-Y') . '.pdf');
    }
}
