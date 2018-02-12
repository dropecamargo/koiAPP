@extends('cartera.notas.main')

@section('breadcrumb')
    <li><a href="{{ route('notas.index')}}">Nota</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="nota-create">
		<div id="render-form-nota">
			{{-- Render form nota --}}
		</div>
	</div>
@stop
