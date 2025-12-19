<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;
    protected $table = 'sesiones';

    protected $fillable = [
        'id_grupo',
        'fecha',
        'tema',
        'estado_sesion',
        'tipo_sesion',
        'observacion',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_sesion');
    }
}
