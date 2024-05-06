@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Escuelas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">


                        @can('crear-blog')
                        <a class="btn btn-warning" href="{{ route('escuelas.create') }}">Nuevo</a>
                        @endcan

                        <table class="table table-striped mt-2 table_id" id="miTabla">
                                <thead style="background-color:#6777ef">
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th>
                                    <th style="color:#fff;">Direccion</th>
                                    <th style="color:#fff;">Clave</th>
                                    <th style="color:#fff;">Acciones</th>
                              </thead>
                              <tbody>
                            @foreach ($escuelas as $escuela)
                            <tr>
                                <td style="display: none;">{{ $escuela->id }}</td>
                                <td>{{ $escuela->nombre }}</td>
                                <td>{{ $escuela->direccion }}</td>
                                <td>{{ $escuela->clave }}</td>
                                <td>
                                    <form action="{{ route('escuelas.destroy',$escuela->id) }}" method="POST">
                                        {{-- @can('editar-blog') --}}
                                        <a class="btn btn-info" href="{{ route('escuelas.edit',$escuela->id) }}">Editar</a>
                                        {{-- @endcan --}}

                                        @csrf
                                        @method('DELETE')
                                        {{-- @can('borrar-blog') --}}
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
                            {!! $escuelas->links() !!}
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
        { Direccion: 'Direccion' },
        { Acciones: 'Acciones' }
    ],

    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    }
});
    </script>
@endsection
