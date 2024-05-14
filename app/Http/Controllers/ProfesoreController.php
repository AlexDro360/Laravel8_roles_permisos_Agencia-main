<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesore;
class ProfesoreController extends Controller
{
    public function index()
    {
         //Con paginación
         $profesores = Profesore::paginate(5);
         return view('profesores.index',compact('profesores'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $blogs->links() !!}
    }

    public function create()
    {
        return view('profesores.crear');
    }

    public function store(Request $request)
    {
        request()->validate([
            'nombre' => 'required',
            'apellidoP' => 'required',
            'apellidoM'=>'required',
            'sexo'=>'required|max:1',
            'numero_tarjeta'=>'required',
        ]);

        Profesore::create($request->all());

        return redirect()->route('profesores.index');
    }

    public function edit(Profesore $profesore)
    {
        return view('profesores.editar',compact('profesore'));
    }

    public function update(Request $request, Profesore $profesore)
    {
        request()->validate([
            'nombre' => 'required',
            'apellidoP' => 'required',
            'apellidoM'=>'required',
            'sexo'=>'required|max:1',
            'numero_tarjeta'=>'required',
        ]);

        $profesore->update($request->all());

        return redirect()->route('profesores.index');
    }

    public function destroy(Profesore $profesore)
    {
        $profesore->delete();

        return redirect()->route('profesores.index');
    }
}
