@extends('tesoreria.egreso.main')

@section('breadcrumb')
    <li><a href="{{ route('egresos.index')}}">Egreso</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="egreso1-create">
		<div id="render-form-egreso1">
			{{-- Render form egreso1 --}}
		</div>
	</div>
@stop
