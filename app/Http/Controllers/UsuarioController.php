<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        //Sin paginación
        $usuarios = User::all();
        //$usuarios = User::paginate(5);
        /* $usuarios = User::all();
        return view('usuarios.index',compact('usuarios')); */

        //Con paginación
        // $usuarios = User::paginate(2);
        return view('usuarios.index',compact('usuarios'));

        //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $usuarios->links() !!}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //aqui trabajamos con name de las tablas de users
        $roles = Role::pluck('name','name')->all();
        return view('usuarios.crear',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ ]+$/',
            'apellidoP' => 'required|alpha',
            'apellidoM' => 'required|alpha',
            'sexo' => 'required',
            'curp'=>['required','unique:users,curp','regex:/^[A-ZÑ]{4}\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])[HM](AS|B[CS]|C[LSCMH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[TLE]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NÑP-TV-Z]{3}[A-ZÑ0-9]\d{1}+$/'],
            'numero_tarjeta' => 'required|size:16|alpha_num|unique:users,numero_tarjeta',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password|min:8',
            'roles' => 'required'
        ], [
            'name.required' => 'El Nombre es obligatorio.',
            'name.regex' => 'El Nombre solo puede contener letras y espacio.',
            'apellidoP.required' => 'El Apellido Paterno es obligatorio.',
            'apellidoP.alpha' => 'El Apellido Paterno solo puede contener letras.',
            'apellidoM.required' => 'El Apellido Materno es obligatorio.',
            'apellidoM.alpha' => 'El Apellido Materno solo puede contener letras.',
            'sexo.required' => 'El Sexo es obligatorio.',
            'curp.required'=>'La CURP es obligatoria',
            'curp.regex'=>'CURP inválida',
            'curp.unique'=>'Ya existe la CURP ingresada',
            'numero_tarjeta.required' => 'El Número de Tarjeta es obligatorio.',
            'numero_tarjeta.alpha_num' => 'El Número de Tarjeta solo puede contener letras y números.',
            'numero_tarjeta.size' => 'El Número de tarjeta debe tener exactamente 16 caracteres.',
            'numero_tarjeta,unique'=>'Ya existe un registro con el numero de tarjeta ingresado',
            'email.required' => 'El Email es obligatorio.',
            'email.email' => 'El Email debe ser una dirección de correo válida.',
            'email.unique' => 'El Email ya está en uso.',
            'password.required' => 'La Contraseña es obligatorio.',
            'password.min' => 'La contraseña debe de tener minimo 8 caracteres',
            'password.same' => 'Las Contraseñas no coinciden.',
            'roles.required' => 'El Role es obligatorio.'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('usuarios.editar',compact('user','roles','userRole'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóúüÜñÑ ]+$/',
            'apellidoP' => 'required|alpha',
            'apellidoM' => 'required|alpha',
            'sexo' => 'required',
            'curp' => [
                'required',
                'regex:/^[A-ZÑ]{4}\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])[HM](AS|B[CS]|C[LSCMH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[TLE]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NÑP-TV-Z]{3}[A-ZÑ0-9]\d{1}+$/',
                Rule::unique('users')->ignore($id)
            ],
            'numero_tarjeta' => ['required','size:16','alpha_num',Rule::unique('users')->ignore($id)],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)
            ],
            'roles' => 'required'
        ], [
            'name.required' => 'El Nombre es obligatorio.',
            'name.regex' => 'El Nombre solo puede contener letras y espacio.',
            'apellidoP.required' => 'El Apellido Paterno es obligatorio.',
            'apellidoP.alpha' => 'El Apellido Paterno solo puede contener letras.',
            'apellidoM.required' => 'El Apellido Materno es obligatorio.',
            'apellidoM.alpha' => 'El Apellido Materno solo puede contener letras.',
            'sexo.required' => 'El Sexo es obligatorio.',
            'curp.required'=>'La CURP es obligatoria',
            'curp.regex'=>'CURP inválida',
            'curp.unique'=>'Ya existe la CURP ingresada',
            'numero_tarjeta.required' => 'El Número de Tarjeta es obligatorio.',
            'numero_tarjeta.alpha_num' => 'El Número de Tarjeta solo puede contener letras y números.',
            'numero_tarjeta.size' => 'El Número de tarjeta debe tener exactamente 16 caracteres.',
            'numero_tarjeta,unique'=>'Ya existe un registro con el numero de tarjeta ingresado',
            'email.required' => 'El Email es obligatorio.',
            'email.email' => 'El Email debe ser una dirección de correo válida.',
            'email.unique' => 'El Email ya está en uso.',
            'roles.required' => 'El Role es obligatorio.'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index');
    }
}
