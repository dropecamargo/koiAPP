@extends('inventario.subcategoria.main')

@section('breadcrumb')
    <li><a href="{{ route('subcategorias.index')}}">Subcategoría</a></li>
    <li><a href="{{ route('subcategorias.show', ['subcategoria' => $subcategoria->id]) }}">{{ $subcategoria->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-primary" id="subcategoria-create">
		{!! Form::open(['id' => 'form-subcategoria', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-subcategoria">
				{{-- Render form subcategoria --}}
			</div>

			<div class="box-footer clearfix">
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('subcategorias.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
