<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamSemestre extends Model
{
    use HasFactory;
    protected $table = 'param_semestre';

    protected $fillable = [
        'nombre_semestre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    // Accessor para compatibilidad
    public function getSemestreAttribute()
    {
        return $this->nombre_semestre;
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_semestre');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_semestre');
    }
}
