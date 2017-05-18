@extends('cartera.ajustesc.main')

@section('breadcrumb')
    <li><a href="{{ route('ajustesc.index')}}">Ajuste cartera</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="ajustec-create">
		<div id="render-form-ajustec">
			{{-- Render form ajustec --}}
		</div>
	</div>
@stop