@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Panel de Opciones</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">                          
                                <div class="row">
                                    
                                    @php
                                        use App\Models\User;                                               
                                    @endphp
                                    @can('ver-usuario')
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-blue order-card">
                                            <div class="card-block">
                                            <h5>Usuarios</h5>                                               
                                                @php
                                                $cant_usuarios = User::count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{$cant_usuarios}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/usuarios" class="text-white">Ver más</a></p>
                                            </div>                                            
                                        </div>                                    
                                    </div>
                                    @endcan

                                    @php
                                        use App\Models\Profesore;                                              
                                    @endphp
                                    @can('ver-usuario')                                                           
                                    
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-purple order-card">
                                            <div class="card-block">
                                                <h5>Profesores</h5>                                               
                                                @php
                                                $cant_Profesores =  User::role('profesor')->count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fas fa-users f-left"></i><span>{{$cant_Profesores}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/profesores" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan  

                                    @php
                                    use Spatie\Permission\Models\Role;                                           
                                    @endphp
                                    @can('ver-rol')
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-block">
                                            <h5>Roles</h5>                                               
                                                @php
                                                 $cant_roles = Role::count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-user-lock f-left"></i><span>{{$cant_roles}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/roles" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div> 
                                    @endcan

                                    @php
                                        use App\Models\Grupo;                                              
                                    @endphp
                                    @can('ver-grupo')                                                           
                                    
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-pink order-card">
                                            <div class="card-block">
                                                <h5>Grupos</h5>                                               
                                                @php
                                                $cant_grupos = Grupo::count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-book-open f-left"></i><span>{{$cant_grupos}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/grupos" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan  

                                    @php
                                        use App\Models\Materia;                                              
                                    @endphp
                                    @can('ver-grupo')                                                           
                                    
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-orange order-card">
                                            <div class="card-block">
                                                <h5>Materias</h5>                                               
                                                @php
                                                $cant_grupos = Materia::count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-bookmark f-left"></i><span>{{$cant_grupos}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/materias" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan  

                                    @php
                                        use App\Models\MiGrupo;   
                                        use Illuminate\Support\Facades\Auth;                                           
                                    @endphp
                                    @can('mi-grupo')                                                           
                                    
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-purple order-card">
                                            <div class="card-block">
                                                <h5>Mis Grupos</h5>                                               
                                                @php
                                                $userId = Auth::id();
                                                $cant_Migrupos = Grupo::query()->join('periodos','periodos.id','=','grupos.periodos_id')->where('grupos.users_id', $userId)->where('periodos.estado',true)->count();                                           
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-book-reader f-left"></i><span>{{$cant_Migrupos}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/Mis-Grupos" class="text-white">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan  

                                </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

