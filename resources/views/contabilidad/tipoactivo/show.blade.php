@extends('contabilidad.tipoactivo.main')

@section('breadcrumb')
    <li><a href="{{ route('tipoactivos.index')}}">Tipo activo</a></li>
    <li class="active">{{ $tipoactivo->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $tipoactivo->id }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipoactivo->tipoactivo_nombre }}</div>
                </div>
                <div class="form-group col-md-1">
                    <label class="control-label">Vida útil</label>
                    <div>{{ $tipoactivo->tipoactivo_vida_util }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3">
                    <label class="checkbox-inline" for="tipoactivos_activo">
                        <input type="checkbox" id="tipoactivos_activo" name="tipoactivos_activo" value="tipoactivos_activo" disabled {{ $tipoactivo->tipoactivo_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Plan Cuentas</label>
                    <div>{{ $tipoactivo->plancuentas_cuenta }} - {{ $tipoactivo->plancuentas_nombre }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tipoactivos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('tipoactivos.edit', ['tipoactivos' => $tipoactivo->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop