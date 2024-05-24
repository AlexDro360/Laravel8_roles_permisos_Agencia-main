<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PeriodoController extends Controller
{
    //
    public function index()
    {
         $periodos=Periodo::all();
         return view('periodos.index',compact('periodos'));
    }

    public function create()
    {
        return view('periodos.crear');
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $date = $date->toDateString(); 
        $estado = false;
        if($date>=$request->fechaInicio && $date<=$request->fechaFinal ){
            $estado = true;
            $per = Periodo::all();
            foreach($per as $p){
            $p->update(['estado' => false]);
            }
        }

        $request->validate([
            'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ0-9- ]+$/|unique:periodos,nombre',
            'fechaInicio' => 'required',
            'fechaFinal' => 'required',
        ], [
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.regex' => 'El Nombre solo puede contener letras, números o espacio.',
            'nombre.unique' => 'Ya existe ese periodo',
            'fechaInicio.required' => 'La Fecha de Inicio es obligatoria.',
            'fechaFinal.required' => 'La Fecha de Finalización es obligatoria.',
        ]);

        Periodo::create([
            'nombre'=>$request->nombre,
            'fechaInicio'=>$request->fechaInicio,
            'fechaFinal'=>$request->fechaFinal,
            'estado'=>$estado
        ]);

        return redirect()->route('periodos.index');
    }

    public function edit(Periodo $periodo)
    {
        return view('periodos.editar',compact('periodo'));
    }

    public function update(Request $request, Periodo $periodo)
    {
        $request->validate([
            'nombre' => ['required','regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ0-9- ]+$/',Rule::unique('periodos')->ignore($periodo->id)],
            'fechaInicio' => 'required',
            'fechaFinal' => 'required',
        ], [
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.regex' => 'El Nombre solo puede contener letras, números o espacio.',
            'nombre.unique' => 'Ya existe ese periodo',
            'fechaInicio.required' => 'La Fecha de Inicio es obligatoria.',
            'fechaFinal.required' => 'La Fecha de Finalización es obligatoria.',
        ]);

        $date = Carbon::now();
        $date = $date->toDateString(); 
        $estado = false;
        if($date>=$request->fechaInicio && $date<=$request->fechaFinal ){
            $estado = true;
            $per = Periodo::all();
            foreach($per as $p){
            $p->update(['estado' => false]);
            }
        }

        $periodo->update($request->all());
        $periodo->update(['estado'=>$estado]);

        return redirect()->route('periodos.index');
    }

    public function destroy(Periodo $periodo)
    {
        $periodo->delete();

        return redirect()->route('periodos.index');
    }
}
