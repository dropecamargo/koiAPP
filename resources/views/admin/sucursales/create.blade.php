@extends('admin.sucursales.main')

@section('breadcrumb')
    <li><a href="{{ route('sucursales.index')}}">Sucursal</a></li>
	<li class="active">Nueva</li>
@stop

@section('module')
	<div class="box box-primary" id="sucursales-create">
		{!! Form::open(['id' => 'form-sucursales', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-sucursal">
				{{-- Render form sucursal --}}
			</div>

	        <div class="box-footer with-border">
	        	<div class="row">
					<div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
						<a href="{{ route('sucursales.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
