@extends('cartera.autorizacionesca.main')

@section('breadcrumb')
	<li><a href="{{ route('autorizacionesca.index') }}">Autorización</a></li>
	<li class="active">Nueva</li>
@stop

@section('module')
	<div class="box box-success" id="autorizacionesca-create">
		<div id="render-form-autorizacionesca">
			{{-- Render form autorizacionesca --}}
		</div>
	</div>
@stop
