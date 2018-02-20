@extends('inventario.subgrupo.main')

@section('breadcrumb')
    <li><a href="{{ route('subgrupos.index')}}">Subcategoría</a></li>
    <li><a href="{{ route('subgrupos.show', ['subgrupo' => $subgrupo->id]) }}">{{ $subgrupo->subgrupo_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="subgrupo-create">
		{!! Form::open(['id' => 'form-subgrupo', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-subgrupo">
				{{-- Render form subgrupo --}}
			</div>

			<div class="box-footer clearfix">
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('subgrupos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
