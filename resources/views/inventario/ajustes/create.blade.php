@extends('inventario.ajustes.main')

@section('breadcrumb')
	<li><a href="{{ route('ajustes.index') }}">Ajustes</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="ajuste-create">
		<div id="render-form-ajuste">
			{{-- Render form ajuste --}}
		</div>
	</div>
@stop