@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear grupos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                <strong>¡Revise los campos!</strong>
                                @foreach ($errors->all() as $error)
                                    <span class="badge badge-danger">{{ $error }}</span>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
        
                    <form action="{{ route('grupos.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clave">Clave</label><span class="required text-danger">*</span>
                                    <input type="text" name="clave" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cupo">Cupo</label><span class="required text-danger">*</span>
                                    <input type="text" name="cupo" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="periodo">Periodo</label><span class="required text-danger">*</span>
                                    <input type="text" name="periodo" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="users_id">Profesor</label><span class="required text-danger">*</span>
                                    {!! Form::select('users_id', $profesores,[], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="materias_id">Materia</label><span class="required text-danger">*</span>
                                    {!! Form::select('materias_id', $materias,[], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="horaInicio">Hora Inicio</label><span class="required text-danger">*</span>
                                    <input type="time" name="horaInicio" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="horaFin">Hora Fin</label><span class="required text-danger">*</span>
                                    <input type="time" name="horaFin" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="dias">Días para la materia:</label><span class="required text-danger">*</span>
                                    <br/>
                                    @foreach($dias as $dia)
                                        <label>{{ Form::checkbox('Dias[]', $dia->id, false, array('class' => 'name')) }}
                                        {{ $dia->nombre }}</label>
                                    <br/>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning">Guardar</button>
                                <a href="/grupos" class="btn btn-primary">Cancelar</a>
                            </div>
                        </div>
                    </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
