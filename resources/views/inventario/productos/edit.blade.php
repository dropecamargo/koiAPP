@extends('inventario.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('productos.index') }}">Producto</a></li>
	<li><a href="{{ route('productos.show', ['productos' => $producto->id]) }}">{{ $producto->producto_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="productos-create">
		<div id="render-form-producto">
			{{-- Render form producto --}}
		</div>
	</div>
@stop
