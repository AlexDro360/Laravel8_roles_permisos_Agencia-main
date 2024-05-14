<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Dia;
use App\Models\Profesore;
use App\Models\Materia;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::query()
        ->join('users','users.id','=','grupos.users_id')
        ->join('materias','materias.id','=','grupos.materias_id')
        ->select('grupos.id as id','grupos.clave as clave','grupos.cupo as cupo','grupos.periodo as periodo','users.*','materias.nombre as nombreM')
        ->get();
        $horarios=null;
        return view('grupos.index',compact('grupos'));
        // return(compact('grupos',));
    }

    public function store(Request $request)
    {
           // $request ->dd();
        request()->validate([
            'clave' => 'required',
            'cupo' => 'required',
            'periodo' => 'required',
            'profesores_id' => 'required',
            'materias_id' => 'required',
            'horaInicio'=>'required',
            'horaFin'=>'required',
            'Dias'=>'required',
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
        $dias = Dia::get();
        $profesores = Profesore::select(DB::raw('CONCAT(nombre," ",apellidoP, " ",apellidoM," ", numero_tarjeta) AS nombreC'),'id')->get()->pluck('nombreC','id');
        $materias = Materia::select(DB::raw('CONCAT(nombre," ", clave) as nombre'),'id')->get()->pluck('nombre','id');
        return view('grupos.crear',compact('dias','materias','profesores'));
    }   

    public function edit(Grupo $grupo)
    {
        $dias = Dia::get();
        $profesores = Profesore::select(DB::raw('CONCAT(nombre," ",apellidoP, " ",apellidoM," ", numero_tarjeta) AS nombreC'),'id')->get()->pluck('nombreC','id');
        $materias = Materia::select(DB::raw('CONCAT(nombre," ", clave) as nombre'),'id')->get()->pluck('nombre','id');
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
            'clave' => 'required',
            'cupo'=>'required',
            'periodo'=>'required',
            'horaInicio'=>'required',
            'horaFin'=>'required',
            'Dias'=>'required',
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
