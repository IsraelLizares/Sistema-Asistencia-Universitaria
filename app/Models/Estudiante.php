<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $table = 'estudiantes';

    protected $fillable = [
        'id_user',
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
        'estado',
        'genero',
        'fecha_ingreso',
        'estado_academico',
        'foto_url',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function carrera()
    {
        return $this->belongsTo(ParamCarrera::class, 'id_carrera');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_estudiante');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_estudiante');
    }
}
