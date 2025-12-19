<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docentes';

    protected $fillable = [
        'id_user',
        'nombre',
        'ap_paterno',
        'ap_materno',
        'ci',
        'celular',
        'email',
        'direccion',
        'profesion',
        'estado',
        'fecha_contratacion',
        'foto_url',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_docente');
    }
}
