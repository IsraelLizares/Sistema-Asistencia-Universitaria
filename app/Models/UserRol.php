<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    use HasFactory;
    protected $table = 'user_rol';

    protected $fillable = [
        'id_user',
        'id_rol',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function rol()
    {
        return $this->belongsTo(ParamRol::class, 'id_rol');
    }
}
