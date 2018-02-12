@extends('inventario.traslados.main')

@section('breadcrumb')
    <li><a href="{{ route('traslados.index')}}">Traslado</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="traslados-create">
		<div class="box-body" id="render-form-traslado">
			{{-- Render form traslado --}}
		</div>
	</div>
@stop
