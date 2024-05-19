<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Dia;
use App\Models\Profesore;
use App\Models\Materia;
use App\Models\User;

use App\Http\Controllers\MiController;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Auth;

class MiGrupoController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Obtenemos la ID del usuario autenticado

        $Migrupos = Grupo::query()
            ->join('users', 'users.id', '=', 'grupos.users_id')
            ->join('materias', 'materias.id', '=', 'grupos.materias_id')
            ->select('grupos.id as id', 'grupos.clave as clave', 'grupos.cupo as cupo', 'grupos.periodo as periodo', 'users.name as nombre', 'users.apellidoP as apellidoP', 'users.apellidoM as apellidoM', 'materias.nombre as nombreM')
            ->where('grupos.users_id', '=', $userId) // Usamos la ID del usuario autenticado
            ->get();

        return view('Migrupos.index', compact('Migrupos'));
    }
}