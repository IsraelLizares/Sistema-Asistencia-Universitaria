<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $table = 'grupos';

    protected $fillable = [
        'id_materia',
        'id_docente',
        'id_semestre',
        'id_turno',
        'id_aula',
        'estado',
    ];

    public function materia()
    {
        return $this->belongsTo(ParamMateria::class, 'id_materia');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    public function semestre()
    {
        return $this->belongsTo(ParamSemestre::class, 'id_semestre');
    }

    public function turno()
    {
        return $this->belongsTo(ParamTurno::class, 'id_turno');
    }

    public function aula()
    {
        return $this->belongsTo(ParamAula::class, 'id_aula');
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'id_grupo');
    }
}
