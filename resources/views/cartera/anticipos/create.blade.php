@extends('cartera.anticipos.main')

@section('breadcrumb')
	<li><a href="{{ route('anticipos.index') }}">Anticipo</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="anticipo-create">
		<div id="render-form-anticipo">
			{{-- Render form anticipo --}}
		</div>
	</div>
@stop
