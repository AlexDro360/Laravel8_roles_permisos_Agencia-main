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

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::query()
        ->join('users','users.id','=','grupos.users_id')
        ->join('materias','materias.id','=','grupos.materias_id')
        ->select('grupos.id as id','grupos.clave as clave','grupos.cupo as cupo','grupos.periodo as periodo','users.name as nombre','users.apellidoP as apellidoP','users.apellidoM as apellidoM','materias.nombre as nombreM')
        ->get();
        $horarios=null;
        return view('grupos.index',compact('grupos'));
        // return(compact('grupos',));
    }

    public function store(Request $request)
    {
        //$request ->dd();
        request()->validate([
            'clave' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'cupo' => 'required|numeric|between:15,45',
            'periodo' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'users_id' => 'required',
            'materias_id' => 'required',
            'horaInicio'=>'required',
            'horaFin'=>'required',
            'Dias'=>'required',
        ], [
            'clave.required' => 'La Clave es obligatorio.',
            'clave.regex' => 'La Clave cuenta con caracteres especiales',
            'cupo.required' => 'El Cupo es obligatorio',
            'cupo.numeric' => 'El Cupo solo acepta números',
            'cupo.between' => 'El Cupo minimo son 15 y maximo 45',
            'periodo.required' => 'El Periodo es obligatorio',
            'periodo.regex' => 'El Periodo solo acepta letras, números y -',
            'user_id.required' => 'El Profesor es obligatorio',
            'materias_id.required' => 'la Materia es obligatorio',
            'horaInicio.required' => 'La Hora Inicio es obligatoria',
            'horaFin.required' => 'La hora Fin es obligatoria',
            'Dias.required' => 'Los Dias son obligatorios',
        ]);

        $registro = Grupo::create($request->all());
        $hI=$request->horaInicio.":00";
        $hF=$request->horaFin.":00";
        foreach($request->Dias as $dia){
            Horario::create(['horaInicio'=>$hI,'horaFin'=> $hF,'dias_id'=>$dia,'grupos_id'=>$registro->id]);
        }
        return redirect()->route('grupos.index');
    }
    
    public function create()
    {
        $ids=collect();
        $us = User::select('id')->get();
        foreach($us as $u){
            $user = User::find($u->id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();
            foreach($userRole as $ur){
                if($ur == 'Profesor'){
                    
                    $ids->push($user->id);
                }
            }
        }
        $profesores = User::select(DB::raw('CONCAT(name," ",apellidoP, " ",apellidoM," ", numero_tarjeta) AS nombreC'),'id')->whereIn('id',$ids)->get()->pluck('nombreC','id');
        $dias = Dia::get();
        $materias = Materia::select(DB::raw('CONCAT(nombre," ", clave) as nombre'),'id')->where('estado','=',true)->pluck('nombre','id');
        return view('grupos.crear',compact('dias','materias','profesores'));
    }   

    public function edit(Grupo $grupo)
    {
        $dias = Dia::get();
        $ids=collect();
        $us = User::select('id')->get();
        foreach($us as $u){
            $user = User::find($u->id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();
            foreach($userRole as $ur){
                if($ur == 'Profesor'){
                    
                    $ids->push($user->id);
                }
            }
        }
        $profesores = User::select(DB::raw('CONCAT(name," ",apellidoP, " ",apellidoM," ", numero_tarjeta) AS nombreC'),'id')->whereIn('id',$ids)->get()->pluck('nombreC','id');
        $materias = Materia::select(DB::raw('CONCAT(nombre," ", clave) as nombre'),'id')->where('estado','=',true)->pluck('nombre','id');
        $diasU = Horario::query()
            ->join('dias','dias.id','=','horarios.dias_id')
            ->select('dias.nombre as nombre','horarios.horaInicio as horaInicio','horarios.horaFin as horaFin')
            ->where('horarios.grupos_id','=',$grupo->id)
            ->get();    
        return view('grupos.editar',compact('grupo','diasU','dias','materias','profesores'));
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();

        return redirect()->route('grupos.index');
    }

    public function update(Request $request, Grupo $grupo )
    {
        request()->validate([
            'clave' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'cupo' => 'required|numeric|between:15,45',
            'periodo' => 'required|regex:/^[A-Za-z0-9-]+$/',
            'users_id' => 'required',
            'materias_id' => 'required',
            'horaInicio'=>'required',
            'horaFin'=>'required',
            'Dias'=>'required',
        ], [
            'clave.required' => 'La Clave es obligatorio.',
            'clave.regex' => 'La Clave cuenta con caracteres especiales',
            'cupo.required' => 'El Cupo es obligatorio',
            'cupo.numeric' => 'El Cupo solo acepta números',
            'cupo.between' => 'El Cupo minimo son 15 y maximo 45',
            'periodo.required' => 'El Periodo es obligatorio',
            'periodo.regex' => 'El Periodo solo acepta letras, números y -',
            'user_id.required' => 'El Profesor es obligatorio',
            'materias_id.required' => 'la Materia es obligatorio',
            'horaInicio.required' => 'La Hora Inicio es obligatoria',
            'horaFin.required' => 'La hora Fin es obligatoria',
            'Dias.required' => 'Los Dias son obligatorios',
        ]);
        //$request->dd();
        $grupo->update($request->all());
        Horario::where('grupos_id', $grupo->id)->delete();
        foreach($request->Dias as $dia){
            Horario::create(['horaInicio'=>$request->horaInicio,'horaFin'=> $request->horaFin,'dias_id'=>$dia,'grupos_id'=>$grupo->id]);
        }
        return redirect()->route('grupos.index');
    }

    public function show(Grupo $grupo)
    {
     //Con paginación
     $grupos = Grupo::query()
                ->join('horarios','horarios.grupos_id','=','grupos.id')
                ->join('dias','dias.id','=','horarios.dias_id')
                ->select('dias.nombre as nombreD')
                ->where('grupos.id','=','$grupo')
                ->get();
     return view('grupos.index',compact('grupos'));
     //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $blogs->links() !!}

    }
}
