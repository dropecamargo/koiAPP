@extends('inventario.lineas.main')

@section('breadcrumb')
    <li><a href="{{ route('lineas.index')}}">Línea</a></li>
    <li class="active">{{ $lineas->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <label class="control-label">Nombre</label>
                    <div>{{ $lineas->linea_nombre }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label">Cuenta de inventario</label>
                    <div>{{ $lineas->plancuentas_cuenta }} - {{ $lineas->plancuentas_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label class="control-label">Nivel 1</label>
                    <div>{{ $lineas->linea_margen_nivel1 }}</div>
                </div>
                <div class="col-sm-2">
                    <label class="control-label">Nivel 2</label>
                    <div>{{ $lineas->linea_margen_nivel2 }}</div>
                </div>
                <div class="col-sm-2">
                    <label class="control-label">Nivel 3</label>
                    <div>{{ $lineas->linea_margen_nivel3 }}</div>
                </div>
                <div class="col-sm-1 col-xs-8"><br>
                    <label class="checkbox-inline" for="linea_activo">
                        <input type="checkbox" id="linea_activo" name="linea_activo" value="linea_activo" disabled {{ $lineas->linea_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                        <a href=" {{ route('lineas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                    <div class="col-sm-2 col-xs-6 text-right">
                        <a href=" {{ route('lineas.edit', ['lineas' => $lineas->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
