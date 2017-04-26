@extends('comercial.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('pedidosc.index') }}">Pedido</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="pedidosc-create">
		<div id="render-form-pedidosc">
			{{-- Render form pedidosc --}}
		</div>
	</div>
@stop