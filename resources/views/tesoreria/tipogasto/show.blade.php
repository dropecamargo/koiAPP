@extends('tesoreria.tipogasto.main')

@section('breadcrumb')
    <li><a href="{{ route('tipogastos.index')}}">Tipo de gasto</a></li>
    <li class="active">{{ $tipogasto->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-5">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipogasto->tipogasto_nombre }}</div>
                </div>
                </br>
                <div class="col-sm-2 col-xs-8">
                    <label class="checkbox-inline" for="tipogastos_activo">
                        <input type="checkbox" id="tipogastos_activo" name="tipogastos_activo" value="tipogastos_activo" disabled {{ $tipogasto->tipogasto_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('tipogastos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('tipogastos.edit', ['tipogastos' => $tipogasto->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
