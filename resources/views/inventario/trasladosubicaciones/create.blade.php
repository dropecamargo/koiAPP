@extends('inventario.trasladosubicaciones.main')

@section('breadcrumb')
    <li><a href="{{ route('trasladosubicaciones.index')}}">Traslados</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="trasladosubicaciones-create">
			<div id="render-form-trasladoubicacion">
			{{-- Render form trasladoubicacion --}}
		</div>
	</div>
@stop