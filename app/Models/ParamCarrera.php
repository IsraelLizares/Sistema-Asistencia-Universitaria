<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamCarrera extends Model
{
    use HasFactory;
    protected $table = 'param_carrera';

    protected $fillable = [
        'nombre_carrera',
        'descripcion',
        'estado',
    ];

    // Accessor para compatibilidad
    public function getCarreraAttribute()
    {
        return $this->nombre_carrera;
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_carrera');
    }

    public function materias()
    {
        return $this->hasMany(ParamMateria::class, 'id_carrera');
    }
}
