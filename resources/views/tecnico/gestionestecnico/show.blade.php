@extends('tecnico.gestionestecnico.main')

@section('breadcrumb')
    <li><a href="{{ route('gestionestecnico.index')}}">Gestion tecnico</a></li>
    <li class="active">{{ $gestiontecnico->id }}</li>
@stop

@section('module')
	<div class="box box-primary">
		<div class="box-body">
			<div class="row">
				<div class="col-sm-4">
					<label>Cliente</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $gestiontecnico->gestiontecnico_tercero ]) }}" title="Ver tercero">{{ $gestiontecnico->cliente_nit }} </a> - {{ $gestiontecnico->tercero_nombre }} </div>
				</div>
				<div class="col-sm-4">
					<label>Concepto tecnico</label>
					<div>{{ $gestiontecnico->conceptotec_nombre }}</div>
				</div>
				<div class="col-sm-4">
					<label>Tecnico</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $gestiontecnico->gestiontecnico_tecnico ]) }}" title="Ver tecnico">{{ $gestiontecnico->tecnico_nit }} </a> - {{ $gestiontecnico->tecnico_nombre }} </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label>Fecha</label>
					<div>{{ $gestiontecnico->gestiontecnico_fh }}</div>
				</div>
				<div class="col-sm-4">
					<label>Fecha inicio</label>
					<div>{{ $gestiontecnico->gestiontecnico_inicio }}</div>
				</div>
				<div class="col-sm-4">
					<label>Fecha finalización</label>
					<div>{{ $gestiontecnico->gestiontecnico_finalizo }}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label>Observaciones</label>
					<div>{{ $gestiontecnico->gestiontecnico_observaciones }}</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
            <div class="col-sm-2 col-sm-offset-5 col-xs-6 text-left">
                <a href="{{ route('gestionestecnico.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
		</div>
	</div>
@stop
