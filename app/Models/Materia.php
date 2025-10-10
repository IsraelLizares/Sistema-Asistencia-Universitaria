<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';
    protected $fillable = [
        'nombrea',
        'codigo',
        'id_carrera',
        'estado'
    ];

    // Relación con Carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }
}
