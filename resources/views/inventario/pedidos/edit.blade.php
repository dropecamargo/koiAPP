@extends('inventario.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
	<li><a href="{{ route('pedidos.show', ['pedido' => $pedido1->id]) }}">{{ $pedido1->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="pedido-create">
		<div id="render-form-pedido">
			{{-- Render form pedidos --}}
		</div>
	</div>
@stop