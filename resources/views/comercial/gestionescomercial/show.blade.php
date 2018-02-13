@extends('comercial.gestionescomercial.main')

@section('breadcrumb')
    <li><a href="{{ route('gestionescomercial.index')}}">Gestión comercial</a></li>
    <li class="active">{{ $gestioncomercial->id }}</li>
@stop

@section('module')
	<div class="box box-primary">
		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-4">
					<label class="control-label">Cliente</label>
                    <div>{{ $gestioncomercial->tercero_nombre }} <br><a href="{{ route('terceros.show', ['terceros' =>  $gestioncomercial->gestioncomercial_tercero ]) }}" title="Ver tercero">{{ $gestioncomercial->cliente_nit }} </a></div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Concepto comercial</label>
					<div>{{ $gestioncomercial->conceptocom_nombre }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Vendedor</label>
                    <div>{{ $gestioncomercial->vendedor_nombre }} <br><a href="{{ route('terceros.show', ['terceros' =>  $gestioncomercial->gestioncomercial_vendedor ]) }}" title="Ver vendedor">{{ $gestioncomercial->vendedor_nit }} </a></div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<label class="control-label">Fecha</label>
					<div>{{ $gestioncomercial->gestioncomercial_fh }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Fecha inicio</label>
					<div>{{ $gestioncomercial->gestioncomercial_inicio }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Fecha finalización</label>
					<div>{{ $gestioncomercial->gestioncomercial_finalizo }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Observaciones</label>
					<div>{{ $gestioncomercial->gestioncomercial_observaciones }}</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                <a href="{{ route('gestionescomercial.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
		</div>
	</div>
@stop
