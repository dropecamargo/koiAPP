@extends('inventario.tiposajuste.main')

@section('breadcrumb')
    <li><a href="{{ route('tiposajuste.index')}}">Tipo de ajuste</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="tipoajuste-create">
		<div class="box-body" id="render-form-tipoajuste">
			{{-- Render form tiposajuste --}}
		</div>
	</div>
@stop
