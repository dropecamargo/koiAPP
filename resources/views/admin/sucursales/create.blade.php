@extends('admin.sucursales.main')

@section('breadcrumb')
    <li><a href="{{ route('sucursales.index')}}">Sucursal</a></li>
	<li class="active">Nueva</li>
@stop

@section('module')
	<div class="box box-primary" id="sucursales-create">
		<div id="render-form-sucursal">
			{{-- Render form sucursal --}}
		</div>
	</div>
@stop
