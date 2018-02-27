@extends('tecnico.tipoorden.main')

@section('breadcrumb')
    <li><a href="{{ route('tiposorden.index')}}">Tipo de orden</a></li>
    <li class="active">{{ $tipoorden->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-8">
                    <label>Nombre</label>
                    <div>{{ $tipoorden->tipoorden_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label>Tipo de ajuste</label>
                    <div>{{ $tipoorden->tipoajuste->tipoajuste_nombre }}</div>
                </div>
                <div class="col-sm-2 col-xs-8"><br>
                    <label class="checkbox-inline" for="tipoorden_activo">
                        <input type="checkbox" id="tipoorden_activo" name="tipoorden_activo" value="tipoorden_activo" disabled {{ $tipoorden->tipoorden_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('tiposorden.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('tiposorden.edit', ['tiposorden' => $tipoorden->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
