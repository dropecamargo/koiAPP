@extends('inventario.modelo.main')

@section('breadcrumb')
    <li><a href="{{ route('modelos.index')}}">Modelo</a></li>
    <li class="active">{{ $modelo->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Marca</label>
                    <div>{{ $modelo->marca->marca_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Nombre</label>
                    <div>{{ $modelo->modelo_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="modelo_activo">
                        <input type="checkbox" id="modelo_activo" name="modelo_activo" value="modelo_activo" disabled {{ $modelo->modelo_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-footer">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('modelos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('modelos.edit', ['modelo' => $modelo->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
