@extends('cartera.devoluciones.main')

@section('breadcrumb')
	<li><a href="{{ route('devoluciones.index') }}">Devolución</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="devolucion-create">
		<div id="render-form-devolucion">
			{{-- Render form devolucion --}}
		</div>
	</div>
@stop
