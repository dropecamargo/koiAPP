@extends('contabilidad.documentos.main')

@section('breadcrumb')
    <li><a href="{{ route('documentos.index')}}">Documentos</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="documento-create">
		{!! Form::open(['id' => 'form-documento', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-documento">
				{{-- Render form documentos --}}
			</div>

	        <div class="box-footer with-border">
	        	<div class="row">
					<div class="col-sm-offset-4 col-sm-2 col-xs-6 text-left">
						<a href="{{ route('documentos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
