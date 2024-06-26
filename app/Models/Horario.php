<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $fillable = ['horaInicio', 'horaFin', 'dias_id', 'grupos_id'];
}
