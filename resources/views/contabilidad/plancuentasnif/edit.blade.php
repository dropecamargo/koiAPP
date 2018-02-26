@extends('contabilidad.plancuentasnif.main')

@section('breadcrumb')
	<li><a href="{{ route('plancuentasnif.index') }}">Plan de cuentas</a></li>
	<li><a href="{{ route('plancuentasnif.show', ['plancuentasnif' => $plancuentanif->id]) }}">{{ $plancuentanif->plancuentasn_cuenta }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="plancuentasnif-create">
		{!! Form::open(['id' => 'form-plancuentasnif', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-plancuentasnif">
				{{-- Render form plancuentas --}}
			</div>

	        <div class="box-footer with-border">
	        	<div class="row">
					<div class="col-sm-offset-4 col-sm-2 col-xs-6 text-left">
						<a href="{{ route('plancuentasnif.show', ['plancuentasnif' => $plancuentanif->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
