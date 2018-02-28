@extends('tecnico.sitios.main')

@section('breadcrumb')
    <li><a href="{{ route('sitios.index')}}">Sitio de atención</a></li>
    <li><a href="{{ route('sitios.show', ['sitio' => $sitio->id]) }}">{{ $sitio->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="sitio-create">
		{!! Form::open(['id' => 'form-sitio', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-sitio">
				{{-- Render form sitio --}}
			</div>

			<div class="box-footer ">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
						<a href="{{ route('sitios.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
