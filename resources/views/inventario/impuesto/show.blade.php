@extends('inventario.impuesto.main')

@section('breadcrumb')
    <li><a href="{{ route('impuestos.index')}}">Impuesto</a></li>
    <li class="active">{{ $impuesto->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $impuesto->impuesto_nombre }}</div>
                </div>
                <div class="form-group col-md-5">
                    <label class="control-label">Plan cuenta</label>
                    <div>{{ $impuesto->plancuentas_cuenta}} - {{ $impuesto->plancuentas_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Porcentaje %</label>
                    <div>{{ $impuesto->impuesto_porcentaje }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="impuestos_activo">
                        <input type="checkbox" id="impuestos_activo" name="impuestos_activo" value="impuestos_activo" disabled {{ $impuesto->impuesto_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('impuestos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('impuestos.edit', ['impuestos' => $impuesto->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
