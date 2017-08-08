@extends('inventario.lineas.main')

@section('breadcrumb')
    <li><a href="{{ route('lineas.index')}}">Línea</a></li>
    <li class="active">{{ $lineas->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $lineas->linea_nombre }}</div>
                </div>
                <div class="form-group col-md-1 col-xs-8"><br>
                    <label class="checkbox-inline" for="linea_activo">
                        <input type="checkbox" id="linea_activo" name="linea_activo" value="linea_activo" disabled {{ $lineas->linea_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>

            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                        <a href=" {{ route('lineas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('lineas.edit', ['lineas' => $lineas->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
