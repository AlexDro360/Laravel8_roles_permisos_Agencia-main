@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Grupo</h3>
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

                        <form action="{{ route('grupos.update',$grupo->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                       <label for="clave">Clave</label>
                                       <input type="text" name="clave" class="form-control" value="{{ $grupo->clave }}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                       <label for="cupo">Cupo</label>
                                       <input type="text" name="cupo" class="form-control" value="{{ $grupo->cupo }}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                       <label for="periodo">Periodo</label>
                                       <input type="text" name="periodo" class="form-control" value="{{ $grupo->periodo }}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="users_id">Profesor</label><span class="required text-danger">*</span>
                                        {!! Form::select('users_id', $profesores,$grupo->users_id, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="materias_id">Materia</label><span class="required text-danger">*</span>
                                        {!! Form::select('materias_id', $materias,$grupo->materias_id, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                       <label for="horaInicio">Hora Inicio</label>
                                       <input type="time" name="horaInicio" class="form-control" value="{{$diasU->first()->horaInicio}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                       <label for="horaFin">Hora Fin</label>
                                       <input type="time" name="horaFin" class="form-control" value="{{$diasU->first()->horaFin}}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Dias para la materia:</label><span class="required text-danger">*</span>
                                        <br/>
                                        @php
                                            $d = $diasU->pluck('nombre');
                                        @endphp
                                        <br/>
                                        @foreach($dias as $dia) 
                                            <label>{{ Form::checkbox('Dias[]', $dia->id, $d->contains($dia->nombre), array('class' => 'name')) }}
                                            {{ $dia->nombre }}</label>
                                            <br/>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="/grupos" class="btn btn-warning">Cancelar</a>
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

