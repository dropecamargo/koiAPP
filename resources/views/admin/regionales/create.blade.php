@extends('admin.regionales.main')

@section('breadcrumb')
    <li><a href="{{ route('regionales.index')}}">Regional</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-primary" id="regional-create">
		{!! Form::open(['id' => 'form-regional', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-regional">
				{{-- Render form regional --}}
			</div>

			<div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
						<a href="{{ route('regionales.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-sm-2 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
