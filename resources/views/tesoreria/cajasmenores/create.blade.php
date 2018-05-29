@extends('tesoreria.cajasmenores.main')

@section('breadcrumb')
    <li><a href="{{ route('cajasmenores.index')}}">Caja Menor</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="cajamenor-create">
		<div class="box-body" id="render-form-cajamenor">
			{{-- Render form cajamenor --}}
		</div>
	</div>
@stop
