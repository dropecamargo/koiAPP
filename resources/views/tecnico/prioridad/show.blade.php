@extends('tecnico.prioridad.main')

@section('breadcrumb')
    <li><a href="{{ route('prioridades.index')}}">Prioridades</a></li>
    <li class="active">{{ $prioridad->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Nombre</label>
                    <div>{{ $prioridad->prioridad_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="prioridad_activo">
                        <input type="checkbox" id="prioridad_activo" name="prioridad_activo" value="prioridad_activo" disabled {{ $prioridad->prioridad_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('prioridades.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('prioridades.edit', ['prioridades' => $prioridad->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
