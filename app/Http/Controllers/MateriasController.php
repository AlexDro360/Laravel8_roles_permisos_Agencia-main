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
        request()->validate([
            'nombre' => 'required',
            'clave' => 'required',
            'creditos'=>'required|max:1',
            'num_unidades'=>'required|max:1',
            'estado'=>'required',
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
        request()->validate([
            'nombre' => 'required',
            'clave' => 'required',
            'creditos'=>'required',
            'num_unidades'=>'required',
            'estado'=>'required',
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
