<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'ci',
        'telefono',
        'email',
        'direccion',
        'fecha_nacimiento',
        'id_carrera',
        'turno',
        'matricula',
        'estado'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }
}
