@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Grupos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                        @can('crear-grupo')
                        <a class="btn btn-warning" href="{{ route('grupos.create') }}">Nuevo</a>
                        @endcan

                        <table class="table table-striped mt-2 table_id" id="miTabla">
                                <thead style="background-color:#6777ef">
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Clave</th>
                                    <th style="color:#fff;">Cupo</th>
                                    <th style="color:#fff;">Periodo</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">Materia</th>
                                    <th style="color:#fff;">Dias</th>
                                    <th style="color:#fff;">Hora de Inicio</th>
                                    <th style="color:#fff;">Hora de Fin</th>
                                    <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                            @php
                                use App\Models\Horario;
                                use App\Models\Dia;
                            @endphp
                            @foreach ($grupos as $grupo)   
                            <tr>
                                <td style="display: none;">{{ $grupo->id }}</td>
                                <td>{{ $grupo->clave }}</td>
                                <td>{{ $grupo->cupo }}</td>
                                <td>{{ $grupo->periodo }}</td>
                                <td>{{ $grupo->nombre }} {{ $grupo->apellidoP }} {{ $grupo->apellidoM}}</td>
                                <td>{{ $grupo->nombreM }}</td>
                                @php
                                    $dias = Horario::query()
                                            ->join('dias','dias.id','=','horarios.dias_id')
                                            ->select('dias.nombre as nombre','horarios.horaInicio as horaInicio','horarios.horaFin as horaFin')
                                            ->where('horarios.grupos_id','=',$grupo->id)
                                            ->get();        
                                @endphp 
                                <td>
                                    @foreach($dias as $dia)
                                        {{$dia->nombre}} 
                                    @endforeach  
                                </td>
                                @php
                                    $hora=$dias->first();
                                @endphp
                                <td>
                                    
                                    {{$hora->horaInicio}}
                                </td>
                                <td>
                                    
                                    {{$hora->horaFin}}
                                </td>  
                                <td>
                                    <form action="{{ route('grupos.destroy',$grupo->id) }}" method="POST">
                                        {{-- @can('editar-grupo') --}}
                                        <a class="btn btn-info" href="{{ route('grupos.edit',$grupo->id) }}">Editar</a>
                                        {{-- @endcan --}}

                                        @csrf
                                        @method('DELETE')
                                        {{-- @can('borrar-grupo') --}}
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        {{-- @endcan --}}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Ubicamos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                            {!! $grupo->links() !!}
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        new DataTable('#miTabla', {
    lengthMenu: [
        [2, 5, 10],
        [2, 5, 10]
    ],

    columns: [
        { Id: 'Id' },
        { Clave: 'Clave' },
        { Cupo: 'Cupo' },
        { Periodo: 'Periodo' },
        { Nombre: 'Nombre' },
        { Materia: 'Materia' },
        { Dias: 'Dias' },
        { HoraF: 'horaInicio' },
        { HoraI: 'horaFin' },
        { Acciones: 'Acciones' }
    ],

    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    }
});
    </script>
@endsection
