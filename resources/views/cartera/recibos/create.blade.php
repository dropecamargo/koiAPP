@extends('cartera.recibos.main')

@section('breadcrumb')
    <li><a href="{{ route('recibos.index')}}">Recibo</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="recibo1-create">
		<div id="render-form-recibo1">
			{{-- Render form recibo1 --}}
		</div>
	</div>
@stop