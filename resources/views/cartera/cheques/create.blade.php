@extends('cartera.cheques.main')

@section('breadcrumb')
	<li><a href="{{ route('cheques.index') }}">Cheque</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="cheque-create">
		<div id="render-form-cheque">
			{{-- Render form cheque --}}
		</div>
	</div>
@stop
