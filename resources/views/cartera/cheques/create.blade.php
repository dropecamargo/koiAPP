@extends('cartera.cheques.main')

@section('breadcrumb')
	<li><a href="{{ route('cheques.index') }}">Cheques</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="cheque-create">
		<div id="render-form-cheque">
			{{-- Render form cheque --}}
		</div>
	</div>
@stop