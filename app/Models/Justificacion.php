<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justificacion extends Model
{
    use HasFactory;
    protected $table = 'justificaciones';

    protected $fillable = [
        'id_asistencia',
        'motivo',
        'documento_url',
        'estado_justificacion',
        'fecha_solicitud',
        'fecha_resolucion',
        'id_usuario_revisor',
    ];

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'id_asistencia');
    }

    public function revisor()
    {
        return $this->belongsTo(User::class, 'id_usuario_revisor');
    }
}
