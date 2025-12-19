<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'asistencias';

    protected $fillable = [
        'id_sesion',
        'id_estudiante',
        'estado_asistencia',
        'observacion',
        'id_usuario_registro',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'id_sesion');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro');
    }

    public function justificacion()
    {
        return $this->hasOne(Justificacion::class, 'id_asistencia');
    }
}
