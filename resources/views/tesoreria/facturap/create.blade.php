@extends('tesoreria.facturap.main')

@section('breadcrumb')
	<li><a href="{{ route('facturasp.index') }}">Facturas proveedor</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="facturap-create">
		<div id="render-form-facturap">
			{{-- Render form facturap --}}
		</div>
	</div>
@stop