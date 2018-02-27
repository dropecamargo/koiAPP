@extends('tesoreria.tipopago.main')

@section('breadcrumb')
    <li><a href="{{ route('tipopagos.index')}}">Tipo de pago</a></li>
    <li class="active">{{ $tipopago->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipopago->tipopago_nombre }}</div>
                </div>
                @if($tipopago->tipopago_documentos != null)
                <div class="col-sm-4">
                    <label class="control-label">Documentos</label>
                    <div>{{ $tipopago->documentos_nombre }}</div>
                </div>
                @endif
                <div class="col-sm-1 col-xs-8 col-sm-3">
                    <label class="checkbox-inline" for="tipopagos_activo">
                        <input type="checkbox" id="tipopagos_activo" name="tipopagos_activo" value="tipopagos_activo" disabled {{ $tipopago->tipopago_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('tipopagos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('tipopagos.edit', ['tipopagos' => $tipopago->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
