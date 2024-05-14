<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesore extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'apellidoP', 'apellidoM', 'sexo','numero_tarjeta'];
}
