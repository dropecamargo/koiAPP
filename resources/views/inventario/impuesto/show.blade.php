@extends('inventario.impuesto.main')

@section('breadcrumb')
    <li><a href="{{ route('impuestos.index')}}">Impuesto</a></li>
    <li class="active">{{ $impuesto->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-5">
                    <label>Nombre</label>
                    <div>{{ $impuesto->impuesto_nombre }}</div>
                </div>
                <div class="col-sm-2">
                    <label>Porcentaje %</label>
                    <div>{{ $impuesto->impuesto_porcentaje }}</div>
                </div>
                <div class="col-sm-2 col-xs-8"><br>
                    <label class="checkbox-inline" for="impuestos_activo">
                        <input type="checkbox" id="impuestos_activo" name="impuestos_activo" value="impuestos_activo" disabled {{ $impuesto->impuesto_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <label>Cuenta de impuestos</label>
                    <div>{{ $impuesto->plancuentas_cuenta }} - {{ $impuesto->plancuentas_nombre}}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('impuestos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('impuestos.edit', ['impuestos' => $impuesto->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
