@extends('cartera.conceptosrc.main')

@section('breadcrumb')
    <li><a href="{{ route('conceptosrc.index')}}">Concepto recibo de caja</a></li>
    <li><a href="{{ route('conceptosrc.show', ['conceptosrc' => $conceptosrc->id]) }}">{{ $conceptosrc->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="conceptosrc-create">
		{!! Form::open(['id' => 'form-conceptosrc', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-conceptosrc">
				{{-- Render form conceptosrc --}}
			</div>

			<div class="box-footer clearfix">
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('conceptosrc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
