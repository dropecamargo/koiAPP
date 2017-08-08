@extends('inventario.servicios.main')

@section('breadcrumb')
    <li><a href="{{ route('servicios.index')}}">Servicio</a></li>
    <li class="active">{{ $servicio->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $servicio->servicio_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="servicio_activo">
                        <input type="checkbox" id="servicio_activo" name="servicio_activo" value="servicio_activo" disabled {{ $servicio->servicio_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('servicios.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
