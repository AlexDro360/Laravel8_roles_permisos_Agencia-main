@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Periodos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                        @can('crear-periodo')
                        <a class="btn btn-warning" href="{{ route('periodos.create') }}">Nuevo Periodo</a>
                        @endcan

                        <table class="table table-striped mt-2 table_id" id="miTabla">
                                <thead style="background-color:#ffa426">
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">Fecha de Inicio</th>
                                    <th style="color:#fff;">Fecha de Finalización</th>
                                    <th style="color:#fff;">Estado</th>
                                    <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                            <!-- @php
                                use App\Models\Grupo;
                            @endphp -->
                            @php
                                use App\Models\Periodo;
                            @endphp
                            @foreach ($periodos as $periodo)
                            <tr>
                                <td style="display: none;">{{ $periodo->id }}</td>
                                <td>{{ $periodo->nombre }}</td>
                                <td>{{ $periodo->fechaInicio }}</td>
                                <td>{{ $periodo->fechaFinal }}</td>
                                @if($periodo->estado)
                                <td>Activo</td>
                                @else
                                <td>Inactivo</td>
                                @endif
                                <td>
                                    <form action="{{ route('periodos.destroy',$periodo->id) }}" method="POST">
                                        {{-- @can('editar-'periodo'') --}}
                                        <a class="btn btn-info" href="{{ route('periodos.edit',$periodo->id) }}">Editar</a>
                                        {{-- @endcan --}}

                                        
                                        @if($periodo->estado == false)
                                            @csrf
                                            @method('DELETE')
                                            {{-- @can('borrar-periodo') --}}
                                            <button type="submit" class="btn btn-danger">Borrar</button>
                                            {{-- @endcan --}}
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Ubicamos la paginacion a la derecha -->
                        {{-- <div class="pagination justify-content-end">
                            {!! $materias->links() !!}
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
        { Nombre: 'Nombre' },
        { FechaInicio: 'fechaInicio' },
        { FechaFinal: 'fechaFinal' },
        { Acciones: 'Acciones' },
        { Estado: 'estado' }
    ],

    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    }
});
    </script>
@endsection
