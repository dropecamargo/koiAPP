@extends('tesoreria.retefuente.main')

@section('breadcrumb')
    <li><a href="{{ route('retefuentes.index')}}">Retención en la fuente</a></li>
    <li><a href="{{ route('retefuentes.show', ['retefuente' => $retefuente->id]) }}">{{ $retefuente->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="retefuente-create">
		{!! Form::open(['id' => 'form-retefuente', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-retefuente">
				{{-- Render form retefuente --}}
			</div>

			<div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
						<a href="{{ route('retefuentes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
