@extends('tecnico.gestionestecnico.main')

@section('breadcrumb')
    <li><a href="{{ route('gestionestecnico.index')}}">Gestion tecnico</a></li>
    <li class="active">{{ $gestiontecnico->id }}</li>
@stop

@section('module')
	<div class="box box-success">
		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-4">
					<label class="control-label">Cliente</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $gestiontecnico->gestiontecnico_tercero ]) }}" title="Ver tercero">{{ $gestiontecnico->cliente_nit }} </a> - {{ $gestiontecnico->tercero_nombre }} </div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Concepto tecnico</label>
					<div>{{ $gestiontecnico->conceptotec_nombre }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Tecnico</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $gestiontecnico->gestiontecnico_tecnico ]) }}" title="Ver tecnico">{{ $gestiontecnico->tecnico_nit }} </a> - {{ $gestiontecnico->tecnico_nombre }} </div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<label class="control-label">Fecha</label>
					<div>{{ $gestiontecnico->gestiontecnico_fh }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Fecha inicio</label>
					<div>{{ $gestiontecnico->gestiontecnico_inicio }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Fecha finalización</label>
					<div>{{ $gestiontecnico->gestiontecnico_finalizo }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Observaciones</label>
					<div>{{ $gestiontecnico->gestiontecnico_observaciones }}</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                <a href="{{ route('gestionestecnico.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
		</div>
	</div>
@stop
