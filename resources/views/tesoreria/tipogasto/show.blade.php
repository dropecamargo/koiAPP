@extends('tesoreria.tipogasto.main')

@section('breadcrumb')
    <li><a href="{{ route('tipogastos.index')}}">Tipo gasto</a></li>
    <li class="active">{{ $tipogasto->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $tipogasto->id }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-5">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipogasto->tipogasto_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3">
                    <label class="checkbox-inline" for="tipogastos_activo">
                        <input type="checkbox" id="tipogastos_activo" name="tipogastos_activo" value="tipogastos_activo" disabled {{ $tipogasto->tipogasto_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Plan Cuentas</label>
                    <div>{{ $tipogasto->plancuentas_cuenta }} - {{ $tipogasto->plancuentas_nombre }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tipogastos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('tipogastos.edit', ['tipogastos' => $tipogasto->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop