@extends('admin.sucursales.main')

@section('breadcrumb')
	<li><a href="{{ route('sucursales.index') }}">Sucursal</a></li>
	<li><a href="{{ route('sucursales.show', ['sucursales' => $sucursal->id]) }}">{{ $sucursal->sucursal_nombre }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="sucursales-create">
		<div id="render-form-sucursal">
			{{-- Render form sucursal --}}
		</div>
	</div>
@stop
