@extends('tecnico.dano.main')

@section('breadcrumb')
    <li><a href="{{ route('danos.index')}}">Daño</a></li>
    <li><a href="{{ route('danos.show', ['dano' => $dano->id]) }}">{{ $dano->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="dano-create">
		{!! Form::open(['id' => 'form-dano', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-dano">
				{{-- Render form dano --}}
			</div>

			<div class="box-footer ">
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('danos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
