<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use Illuminate\Validation\Rule;

class MateriasController extends Controller
{
    public function index()
    {
         //Con paginación
         $materias = Materia::paginate(5);
         return view('materias.index',compact('materias'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $blogs->links() !!}
    }

    public function create()
    {
        return view('materias.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ0-9 ]+$/',
            'clave' => 'required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúüÜñÑ-]+$/|unique:materias,clave',
            'creditos' => 'required|numeric|between:1,9',
            'num_unidades' => 'required|numeric|between:1,9',
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
            'estado.required' => 'El estado es obligatorio.'
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index');
    }

    public function edit(Materia $materia)
    {
        return view('materias.editar',compact('materia'));
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
        'estado.required' => 'El estado es obligatorio.'
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
