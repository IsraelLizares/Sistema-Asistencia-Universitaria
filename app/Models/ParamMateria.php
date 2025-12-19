<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamMateria extends Model
{
    use HasFactory;
    protected $table = 'param_materia';

    protected $fillable = [
        'nombre_materia',
        'codigo_materia',
        'id_carrera',
        'estado',
    ];

    // Accessors para compatibilidad
    public function getMateriaAttribute()
    {
        return $this->nombre_materia;
    }

    public function getSiglaAttribute()
    {
        return $this->codigo_materia;
    }

    public function carrera()
    {
        return $this->belongsTo(ParamCarrera::class, 'id_carrera');
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_materia');
    }
}
