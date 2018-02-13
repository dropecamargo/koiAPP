@extends('contabilidad.activofijos.main')

@section('breadcrumb')
    <li><a href="{{ route('activosfijos.index')}}">Activos fijos</a></li>
    <li class="active">{{ $activofijos->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $activofijos->id }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Placa</label>
                    <div>{{ $activofijos->activofijo_placa }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Serie</label>
                    <div>{{ $activofijos->activofijo_serie }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha de compra</label>
                    <div>{{ $activofijos->activofijo_compra }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha de activación</label>
                    <div>{{ $activofijos->activofijo_activacion }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Tipo</label>
                    <div>{{ $activofijos->tipoactivo_nombre }}</div>
                </div>
                <div class="form-group col-md-1">
                    <label class="control-label">Vida útil</label>
                    <div>{{ $activofijos->activofijo_vida_util }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Costo</label>
                    <div>{{ number_format($activofijos->activofijo_costo) }} </div>
                </div>
                <div class="form-group col-md-1">
                    <label class="control-label">Depreciación</label>
                    <div>{{ number_format($activofijos->activofijo_depreciacion) }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Responsable</label>
                    <div>{{ $activofijos->tercero_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Descripción</label>
                    <div>{{ $activofijos->activofijo_descripcion }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('activosfijos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
