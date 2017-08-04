@extends('inventario.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('pedidos.index') }}">Pedido</a></li>
	<li><a href="{{ route('pedidos.show', ['pedido1' => $pedido1->id]) }}">{{ $pedido1->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-whithout-border" id="pedido-create">
		<div id="render-form-pedido">
			{{-- Render form pedido --}}
		</div>
	</div>
@stop
