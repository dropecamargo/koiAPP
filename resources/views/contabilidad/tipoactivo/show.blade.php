@extends('contabilidad.tipoactivo.main')

@section('breadcrumb')
    <li><a href="{{ route('tipoactivos.index')}}">Tipos activos</a></li>
    <li class="active">{{ $tipoactivo->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <label>Nombre</label>
                    <div>{{ $tipoactivo->tipoactivo_nombre }}</div>
                </div>
                <div class="col-sm-2">
                    <label>Vida útil</label>
                    <div>{{ $tipoactivo->tipoactivo_vida_util }}</div>
                </div>
                <div class="col-sm-2"><br>
                    <label class="checkbox-inline">
                        <input type="checkbox" id="tipoactivos_activo" name="tipoactivos_activo" value="tipoactivos_activo" disabled {{ $tipoactivo->tipoactivo_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('tipoactivos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('tipoactivos.edit', ['tipoactivos' => $tipoactivo->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
