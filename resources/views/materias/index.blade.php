@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Materias</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                        @can('crear-materia')
                        <a class="btn btn-warning" href="{{ route('materias.create') }}">Nuevo</a>
                        @endcan

                        <table class="table table-striped mt-2 table_id" id="miTabla">
                                <thead style="background-color:#6777ef">
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">Clave</th>
                                    <th style="color:#fff;">Creditos</th>
                                    <th style="color:#fff;">Unidades</th>
                                    <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                            @foreach ($materias as $materia)
                            <tr>
                                <td style="display: none;">{{ $materia->id }}</td>
                                <td>{{ $materia->nombre }}</td>
                                <td>{{ $materia->clave }}</td>
                                <td>{{ $materia->creditos }}</td>
                                <td>{{ $materia->num_unidades }}</td>
                                <td>
                                    <form action="{{ route('materias.destroy',$materia->id) }}" method="POST">
                                        {{-- @can('editar-materia') --}}
                                        <a class="btn btn-info" href="{{ route('materias.edit',$materia->id) }}">Editar</a>
                                        {{-- @endcan --}}

                                        @csrf
                                        @method('DELETE')
                                        {{-- @can('borrar-materia') --}}
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
        { Clave: 'Clave' },
        { Creditos: 'Creditos' },
        { Unidades: 'Num_unidades' },
        { Acciones: 'Acciones' }
    ],

    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    }
});
    </script>
@endsection
