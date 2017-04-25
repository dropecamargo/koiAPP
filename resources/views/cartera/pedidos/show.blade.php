@extends('cartera.pedidos.main')

@section('breadcrumb')
    <li><a href="{{ route('pedidos.index')}}">Pedidos</a></li>
    <li class="active">{{ $pedido->id }}</li>
@stop

@section('module')

@stop