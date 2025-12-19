<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamTurno extends Model
{
    use HasFactory;
    protected $table = 'param_turno';

    protected $fillable = [
        'nombre_turno',
        'hora_inicio',
        'hora_fin',
        'dias',
        'estado',
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_turno');
    }
}
