<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

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
            'clave' => 'required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúüÜñÑ-]+$/',
            'creditos' => 'required|numeric|between:1,9',
            'num_unidades' => 'required|numeric|between:1,9',
            'estado' => 'required',
        ], [
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.regex' => 'El Nombre solo puede contener letras, números o espacio.',
            'clave.required' => 'La Clave es obligatoria.',
            'clave.regex' => 'La Clave solo debe de tener letras, números o -.',
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
            'clave' => 'required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúüÜñÑ-]+$/',
            'creditos' => 'required|numeric|between:1,9',
            'num_unidades' => 'required|numeric|between:1,9',
            'estado' => 'required',
        ], [
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.regex' => 'El Nombre solo puede contener letras, números o espacio.',
            'clave.required' => 'La Clave es obligatoria.',
            'clave.regex' => 'La Clave solo debe de tener letras, números o -.',
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
