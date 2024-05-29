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
    function __construct()
    {
         $this->middleware('permission:mi-grupo', ['only' => ['index']]);
    }
    public function index()
    {
        $userId = Auth::id(); // Obtenemos la ID del usuario autenticado
        $currentDate = date('Y-m-d'); // Obtenemos la fecha actual
        $currentYear = date('Y'); // Obtenemos el año actual

        // Determinar el período
        $startOfYear = "$currentYear-01-01";
        $endOfPeriodA = "$currentYear-08-01";

        if ($currentDate >= $startOfYear && $currentDate <= $endOfPeriodA) {
            $periodo = "$currentYear-A";
        } else {
            $periodo = "$currentYear-B";
        }

        $Migrupos = Grupo::query()
            ->join('users', 'users.id', '=', 'grupos.users_id')
            ->join('materias', 'materias.id', '=', 'grupos.materias_id')
            ->join('periodos', 'periodos.id', '=', 'grupos.periodos_id')
            ->select('grupos.id as id', 'grupos.clave as clave', 'grupos.cupo as cupo', 'periodos.nombre as periodo', 'users.name as nombre', 'users.apellidoP as apellidoP', 'users.apellidoM as apellidoM', 'materias.nombre as nombreM')
            ->where('grupos.users_id', '=', $userId) // Usamos la ID del usuario autenticado
            ->where('periodos.estado', '=', true) // Filtramos por el período calculado
            ->get();

        return view('Migrupos.index', compact('Migrupos'));
    }
}