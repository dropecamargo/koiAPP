@extends('cobro.gestiondeudores.main')

@section('breadcrumb')
    <li><a href="{{ route('gestiondeudores.index')}}">Gestión de deudores</a></li>
    <li class="active">{{ $gestiondeudor->id }}</li>
@stop

@section('module')
	<div class="box box-primary">
		<div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Cliente</label>
                    <div>Documento: <a href="{{ route('terceros.show', ['terceros' =>  $gestiondeudor->deudor_tercero ]) }}" target="_blank" title="Ver tercero">{{ $gestiondeudor->tercero_nit }} </a> <br>
                        Nombre: {{ $gestiondeudor->tercero_nombre }} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Concepto cobro</label>
                    <div>{{ $gestiondeudor->conceptocob_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Nit deudor</label>
                    <div>{{ $gestiondeudor->deudor_nit }} - {{ $gestiondeudor->deudor_digito }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Razón social</label>
                    <div>{!! !empty($gestiondeudor->deudor_razonsocial) ? $gestiondeudor->deudor_razonsocial : '-' !!}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Nombres deudor</label>
                    <div>{{ $gestiondeudor->deudor_nombre1 }} {{ $gestiondeudor->deudor_nombre2 }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Apellidos Deudor</label>
                    <div>{{ $gestiondeudor->deudor_apellido1 }} {{ $gestiondeudor->deudor_apellido2 }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $gestiondeudor->gestiondeudor_fh }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha proxima</label>
                    <div>{{ $gestiondeudor->gestiondeudor_proxima }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $gestiondeudor->gestiondeudor_observaciones }}</div>
                </div>
            </div>
		</div>
		<div class="box-footer">
            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                <a href="{{ route('gestiondeudores.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
		</div>
	</div>
@stop
