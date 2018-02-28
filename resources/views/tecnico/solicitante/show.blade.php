@extends('tecnico.solicitante.main')

@section('breadcrumb')
    <li><a href="{{ route('solicitantes.index')}}">Solicitante</a></li>
    <li class="active">{{ $solicitante->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-8">
                    <label>Nombre</label>
                    <div>{{ $solicitante->solicitante_nombre }}</div>
                </div>
                <div class="col-sm-2 col-xs-8"><br>
                    <label class="checkbox-inline" for="solicitante_activo">
                        <input type="checkbox" id="solicitante_activo" name="solicitante_activo" value="solicitante_activo" disabled {{ $solicitante->solicitante_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('solicitantes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('solicitantes.edit', ['solicitantes' => $solicitante->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
