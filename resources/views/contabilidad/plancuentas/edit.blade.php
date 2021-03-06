@extends('contabilidad.plancuentas.main')

@section('breadcrumb')
	<li><a href="{{ route('plancuentas.index') }}">Plan de cuentas</a></li>
	<li><a href="{{ route('plancuentas.show', ['plancuentas' => $plancuenta->id]) }}">{{ $plancuenta->plancuentas_cuenta }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="plancuentas-create">
		{!! Form::open(['id' => 'form-plancuentas', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-plancuentas">
				{{-- Render form plancuentas --}}
			</div>

	        <div class="box-footer with-border">
	        	<div class="row">
					<div class="col-sm-offset-4 col-sm-2 col-xs-6 text-left">
						<a href="{{ route('plancuentas.show', ['plancuentas' => $plancuenta->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
