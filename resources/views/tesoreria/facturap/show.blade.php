@extends('tesoreria.facturap.main')


@section('module')
	<section class="content-header">
        <h1>
            Facturas proveedor <small>Administración de facturas proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('facturasp.index') }}">Factura proveedor</a></li>
            <li class="active">{{ $facturap1->id }}</li>
        </ol>
    </section>
@stop