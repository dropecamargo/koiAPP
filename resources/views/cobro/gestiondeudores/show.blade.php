@extends('cobro.gestiondeudores.main')

@section('breadcrumb')
    <li><a href="{{ route('gestiondeudores.index')}}">Gestión de deudores</a></li>
    <li class="active">{{ $gestiondeudor->id }}</li>
@stop

@section('module')
	<div class="box box-primary">
		<div class="box-body">
			<div class="row">
			</div>
		</div>
		<div class="box-footer">
            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                <a href="{{ route('gestiondeudores.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
		</div>
	</div>
@stop
