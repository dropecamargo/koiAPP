@extends('admin.ubicaciones.main')

@section('breadcrumb')
    <li><a href="{{ route('ubicaciones.index')}}">Ubicación</a></li>
    <li class="active">{{ $ubicacion->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $ubicacion->ubicacion_nombre }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $ubicacion->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-4"><br>
                    <label class="" for="ubicacion_activo">
                    <input type="checkbox" id="ubicacion_activo" name="ubicacion_activo" value="ubicacion_activo" disabled {{ $ubicacion->ubicacion_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('ubicaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('ubicaciones.edit', ['ubicaciones' => $ubicacion->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
