@extends('inventario.traslados.main')

@section('breadcrumb')
    <li><a href="{{ route('traslados.index')}}">Traslados</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="traslados-create">
		<div class="box-body" id="render-form-traslado">
			{{-- Render form traslado --}}
		</div>
	</div>
@stop