<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamRol extends Model
{
    use HasFactory;
    protected $table = 'param_rol';

    protected $fillable = [
        'nombre_rol',
        'descripcion',
        'estado',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_rol', 'id_rol', 'id_user');
    }

}
