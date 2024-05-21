<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Dia;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\GroupAssigned;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class GrupoController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->get('periodo');
        $grupos = Grupo::query()
        ->join('users','users.id','=','grupos.users_id')
        ->join('materias','materias.id','=','grupos.materias_id')
        ->select('grupos.id as id','grupos.clave as clave','grupos.cupo as cupo','grupos.periodo as periodo','users.name as nombre','users.apellidoP as apellidoP','users.apellidoM as apellidoM','materias.nombre as nombreM')
        ->where('periodo','like',"%$periodo%")
        ->get();

        $fper = collect([''=>'Todos los periodos'])->union(Grupo::get()->pluck('periodo','periodo'));
        
        return view('grupos.index',compact('grupos','periodo','fper'));
    }

    public function create()
    {
        $profesores = User::role('Profesor')
            ->select(DB::raw('CONCAT(name, " ", apellidoP, " ", apellidoM, " ", numero_tarjeta) AS nombreC'), 'id')
            ->get()
            ->pluck('nombreC', 'id');

        $dias = Dia::all();
        $materias = Materia::where('estado', true)
            ->select(DB::raw('CONCAT(nombre, " ", clave) as nombre'), 'id')
            ->pluck('nombre', 'id');
        
        return view('grupos.crear', compact('dias', 'materias', 'profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'cupo' => 'required|numeric|between:15,45',
            'periodo' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'users_id' => 'required',
            'materias_id' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'Dias' => 'required|array',
        ], [
            'clave.required' => 'La Clave es obligatoria.',
            'clave.regex' => 'La Clave contiene caracteres especiales no permitidos.',
            'cupo.required' => 'El Cupo es obligatorio.',
            'cupo.numeric' => 'El Cupo solo acepta números.',
            'cupo.between' => 'El Cupo mínimo es 15 y máximo 45.',
            'periodo.required' => 'El Periodo es obligatorio.',
            'periodo.regex' => 'El Periodo solo acepta letras, números y guiones.',
            'users_id.required' => 'El Profesor es obligatorio.',
            'materias_id.required' => 'La Materia es obligatoria.',
            'horaInicio.required' => 'La Hora de Inicio es obligatoria.',
            'horaFin.required' => 'La Hora de Fin es obligatoria.',
            'Dias.required' => 'Los Días son obligatorios.',
        ]);

        $grupo = Grupo::create($request->all());
        $horaInicio = $request->horaInicio . ":00";
        $horaFin = $request->horaFin . ":00";

        foreach ($request->Dias as $dia) {
            Horario::create([
                'horaInicio' => $horaInicio,
                'horaFin' => $horaFin,
                'dias_id' => $dia,
                'grupos_id' => $grupo->id
            ]);
        }

        // Enviar notificación por correo
        $profesor = User::find($request->users_id);
        $materia = Materia::find($request->materias_id);
        Mail::to($profesor->email)->send(new GroupAssigned($profesor, $grupo, $materia));

        return redirect()->route('grupos.index');
    }

    public function edit(Grupo $grupo)
    {
        $profesores = User::role('Profesor')
            ->select(DB::raw('CONCAT(name, " ", apellidoP, " ", apellidoM, " ", numero_tarjeta) AS nombreC'), 'id')
            ->get()
            ->pluck('nombreC', 'id');

        $dias = Dia::all();
        $materias = Materia::where('estado', true)
            ->select(DB::raw('CONCAT(nombre, " ", clave) as nombre'), 'id')
            ->pluck('nombre', 'id');
        
        $diasU = Horario::where('grupos_id', $grupo->id)
            ->join('dias', 'dias.id', '=', 'horarios.dias_id')
            ->select('dias.nombre as nombre', 'horarios.horaInicio as horaInicio', 'horarios.horaFin as horaFin')
            ->get();

        return view('grupos.editar', compact('grupo', 'diasU', 'dias', 'materias', 'profesores'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'clave' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'cupo' => 'required|numeric|between:15,45',
            'periodo' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'users_id' => 'required',
            'materias_id' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'Dias' => 'required|array',
        ], [
            'clave.required' => 'La Clave es obligatoria.',
            'clave.regex' => 'La Clave contiene caracteres especiales no permitidos.',
            'cupo.required' => 'El Cupo es obligatorio.',
            'cupo.numeric' => 'El Cupo solo acepta números.',
            'cupo.between' => 'El Cupo mínimo es 15 y máximo 45.',
            'periodo.required' => 'El Periodo es obligatorio.',
            'periodo.regex' => 'El Periodo solo acepta letras, números y guiones.',
            'users_id.required' => 'El Profesor es obligatorio.',
            'materias_id.required' => 'La Materia es obligatoria.',
            'horaInicio.required' => 'La Hora de Inicio es obligatoria.',
            'horaFin.required' => 'La Hora de Fin es obligatoria.',
            'Dias.required' => 'Los Días son obligatorios.',
        ]);

        $grupo->update($request->all());
        Horario::where('grupos_id', $grupo->id)->delete();

        foreach ($request->Dias as $dia) {
            Horario::create([
                'horaInicio' => $request->horaInicio,
                'horaFin' => $request->horaFin,
                'dias_id' => $dia,
                'grupos_id' => $grupo->id
            ]);
        }

        // Enviar notificación por correo
        $profesor = User::find($request->users_id);
        $materia = Materia::find($request->materias_id);
        Mail::to($profesor->email)->send(new GroupAssigned($profesor, $grupo, $materia));

        return redirect()->route('grupos.index');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index');
    }

    public function show(Grupo $grupo)
    {
        $horarios = Horario::where('grupos_id', $grupo->id)
            ->join('dias', 'dias.id', '=', 'horarios.dias_id')
            ->select('dias.nombre as nombreD', 'horarios.horaInicio', 'horarios.horaFin')
            ->get();

        return view('grupos.show', compact('grupo', 'horarios'));
    }
}
