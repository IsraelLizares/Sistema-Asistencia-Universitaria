<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamAula extends Model
{
    use HasFactory;
    protected $table = 'param_aula';

    protected $fillable = [
        'codigo_aula',
        'capacidad',
        'tipo',
        'estado',
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_aula');
    }
}
