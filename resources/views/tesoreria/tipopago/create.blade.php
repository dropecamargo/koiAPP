@extends('tesoreria.tipopago.main')

@section('breadcrumb')
    <li><a href="{{ route('tipopagos.index')}}">Tipo de pago</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="tipopago-create">
		{!! Form::open(['id' => 'form-tipopago', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-tipopago">
				{{-- Render form tipopago --}}
			</div>

			<div class="box-footer clearfix">
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('tipopagos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2  col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
