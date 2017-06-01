@extends('tecnico.orden.main')

@section('breadcrumb')
    <li><a href="{{ route('ordenes.index')}}">Orden</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-whithout-border" id="ordenes-create">
		<div id="render-form-orden">
			{{-- Render form orden --}}
		</div>	
	</div>
@stop