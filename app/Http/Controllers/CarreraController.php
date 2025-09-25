<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::select('id', 'nombre', 'descripcion', 'estado')
            ->where("estado", true)
            ->orderBy('id', 'desc')
            ->get();

        // $carreras = Carrera::all();
        return view('carrera.index', compact('carreras'));
    }
}
