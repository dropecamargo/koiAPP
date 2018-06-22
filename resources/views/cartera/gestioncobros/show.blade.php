@extends('cartera.gestioncobros.main')

@section('breadcrumb')
    <li><a href="{{ route('gestioncobros.index')}}">Gestión de cobro</a></li>
    <li class="active">{{ $gestioncobro->id }}</li>
@stop

@section('module')
	<div class="box box-primary">
		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-5">
					<label class="control-label">Cliente</label>
                    <div>Documento: <a href="{{ route('terceros.show', ['terceros' =>  $gestioncobro->gestioncobro_tercero ]) }}" target="_blank" title="Ver tercero">{{ $gestioncobro->tercero_nit }} </a> <br>
                        Nombre: {{ $gestioncobro->tercero_nombre }} </div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Concepto cobro</label>
					<div>{{ $gestioncobro->conceptocob_nombre }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label class="control-label">Fecha</label>
					<div>{{ $gestioncobro->gestioncobro_fh }}</div>
				</div>
				<div class="form-group col-md-5">
					<label class="control-label">Fecha proxima</label>
					<div>{{ $gestioncobro->gestioncobro_proxima }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Observaciones</label>
					<div>{{ $gestioncobro->gestioncobro_observaciones }}</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                <a href="{{ route('gestioncobros.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
		</div>
	</div>
@stop
