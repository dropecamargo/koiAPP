@extends('inventario.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('modelos.index') }}">Pedidos</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-whithout-border" id="pedido-create">
		<div id="render-form-pedido">
			{{-- Render form pedido --}}
		</div>
	</div>
@stop