@extends('inventario.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productos.index')}}">Producto</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="productos-create">
		<div id="render-form-producto">
			{{-- Render form producto --}}
		</div>
	</div>
@stop
