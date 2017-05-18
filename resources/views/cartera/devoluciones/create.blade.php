@extends('cartera.devoluciones.main')

@section('breadcrumb')
	<li><a href="{{ route('devoluciones.index') }}">Devoluciones</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="devolucion-create">
		<div id="render-form-devolucion">
			{{-- Render form devolucion --}}
		</div>
	</div>
@stop