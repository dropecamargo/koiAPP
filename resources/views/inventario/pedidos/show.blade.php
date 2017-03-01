@extends('inventario.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
	<li class="active">{{ $pedido1->id }}-{{ $pedido1->id }}</li>
@stop

@section('module')

	<div class="box box-success" id="pedido-show">

	</div>
@stop