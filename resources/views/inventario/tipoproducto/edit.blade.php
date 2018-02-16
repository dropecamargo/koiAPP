@extends('inventario.tipoproducto.main')

@section('breadcrumb')
	<li><a href="{{ route('tiposproducto.index') }}">Tipo de producto</a></li>
	<li><a href="{{ route('tiposproducto.show', ['tipoproducto' => $tipoproducto->tipoproducto_codigo ]) }}">{{ $tipoproducto->tipoproducto_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="tipoproducto-create">
		{!! Form::open(['id' => 'form-tipoproducto', 'data-toggle' => 'validator']) !!}
	        <div class="box-header with-border">
		        <div class="box-body" id="render-form-tipoproducto">
					{{-- Render form tipoproducto --}}
				</div>
				<div class="box-footer clearfix">
		        	<div class="row">
						<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
							<a href="{{ route('tiposproducto.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
						</div>
						<div class="col-md-2  col-sm-6 col-xs-6 text-right">
							<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
