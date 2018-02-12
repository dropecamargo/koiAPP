@extends('comercial.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('pedidosc.index') }}">Pedido comercial</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="pedidosc-create">
		<div id="render-form-pedidosc">
			{{-- Render form pedidosc --}}
		</div>
	</div>
@stop
