@extends('tesoreria.ajustesp.main')

@section('breadcrumb')
    <li><a href="{{ route('ajustesp.index')}}">Ajuste proveedor</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="ajustep-create">
		<div id="render-form-ajustep">
			{{-- Render form ajustep --}}
		</div>
	</div>
@stop
