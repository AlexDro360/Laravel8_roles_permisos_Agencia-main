<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Departamento;
use Illuminate\Validation\Rule;

class MateriasController extends Controller
{
    public function index(Request $request)
    {
        $dep = $request->departamento;
         $materias=Materia::query()
            ->join('departamentos as d','d.id','=','materias.departamentos_id')
            ->select('materias.*','d.nombre as nombreD')
            ->get();
        if($dep != ''){
            $materias = $materias->where('departamentos_id','=',$dep);
        }
        
        $departamentos = collect([''=>'Todos los departamentos'])->union(Departamento::get()->pluck('nombre','id'));
         return view('materias.index',compact('materias','departamentos','dep'));
    }
    public function obtenerMaterias($departamento)
{
    $materias = Materia::where('departamento_id', $departamento)->get(); 
    return response()->json(['materias' => $materias]);
}

    public function create()
    {
        $departamentos = Departamento::get()->pluck('nombre','id');
        return view('materias.crear',compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ0-9 ]+$/',
            'clave' => 'required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúüÜñÑ-]+$/|unique:materias,clave',
            'creditos' => 'required|numeric|between:1,9',
            'num_unidades' => 'required|numeric|between:1,9',
            'departamentos_id' => 'required',
            'estado' => 'required',
        ], [
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.regex' => 'El Nombre solo puede contener letras, números o espacio.',
            'clave.required' => 'La Clave es obligatoria.',
            'clave.regex' => 'La Clave solo debe de tener letras, números o -.',
            'clave.unique' => 'la clave ya esta en uso',
            'creditos.required' => 'Los créditos son obligatorios.',
            'creditos.numeric' => 'Los créditos solo deben ser un número.',
            'creditos.between' => 'Los créditos deben estar entre 1 y 9.',
            'num_unidades.required' => 'Las Unidades son obligatorias.',
            'num_unidades.numeric' => 'Las Unidades solo deben ser un número.',
            'num_unidades.between' => 'Las Unidades deben estar entre 1 y 9.',
            'estado.required' => 'El estado es obligatorio.',
            'departamentos_id.required'=>'El departamento es obligtorio'
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index');
    }

    public function edit(Materia $materia)
    {
        $departamentos = Departamento::get()->pluck('nombre','id');
        return view('materias.editar',compact('materia','departamentos'));
    }

    public function update(Request $request, Materia $materia)
{
    $request->validate([
        'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ0-9 ]+$/',
        'clave' => [
            'required',
            'regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúüÜñÑ-]+$/',
            Rule::unique('materias')->ignore($materia->id)
        ],
        'creditos' => 'required|numeric|between:1,9',
        'num_unidades' => 'required|numeric|between:1,9',
        'estado' => 'required',
        'departamentos_id' => 'required',
    ], [
        'nombre.required' => 'El Nombre es obligatorio.',
        'nombre.regex' => 'El Nombre solo puede contener letras, números o espacio.',
        'clave.required' => 'La Clave es obligatoria.',
        'clave.regex' => 'La Clave solo debe de tener letras, números o -.',
        'clave.unique' => 'La Clave ya está en uso.',
        'creditos.required' => 'Los créditos son obligatorios.',
        'creditos.numeric' => 'Los créditos solo deben ser un número.',
        'creditos.between' => 'Los créditos deben estar entre 1 y 9.',
        'num_unidades.required' => 'Las Unidades son obligatorias.',
        'num_unidades.numeric' => 'Las Unidades solo deben ser un número.',
        'num_unidades.between' => 'Las Unidades deben estar entre 1 y 9.',
        'estado.required' => 'El estado es obligatorio.',
        'departamentos_id.required' => 'El departamento es obligatorio.'
    ]);

    $materia->update($request->all());

    return redirect()->route('materias.index');
}


    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('materias.index');
    }
}
