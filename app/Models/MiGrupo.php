<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiGrupo extends Model
{
    use HasFactory;
    protected $fillable = ['clave', 'cupo', 'periodo', 'users_id', 'materias_id'];
}
