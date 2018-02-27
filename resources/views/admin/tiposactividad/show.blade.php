@extends('admin.tiposactividad.main')

@section('breadcrumb')
    <li><a href="{{ route('tiposactividad.index')}}">Tipo de actividad</a></li>
    <li class="active">{{ $tipoactividad->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipoactividad->tipoactividad_nombre }}</div>
                </div><br>

		    	<div class="form-group col-sm-1">
			    	<label class="checkbox-inline" for="tipoactividad_activo">
						<input type="checkbox" id="tipoactividad_activo" name="tipoactividad_activo" value="tipoactividad_activo" disabled {{ $tipoactividad->tipoactividad_activo ? 'checked': '' }}> Activo
					</label>
				</div>

				<div class="form-group col-sm-1">
					<label class="checkbox-inline" for="tipoactividad_comercial">
						<input type="checkbox" id="tipoactividad_comercial" name="tipoactividad_comercial" value="tipoactividad_comercial" disabled {{ $tipoactividad->tipoactividad_comercial ? 'checked': '' }}> Comercio
					</label>
				</div>

				<div class="form-group col-sm-1">
					<label class="checkbox-inline" for="tipoactividad_tecnico">
						<input type="checkbox" id="tipoactividad_tecnico" name="tipoactividad_tecnico" value="tipoactividad_tecnico" disabled {{ $tipoactividad->tipoactividad_tecnico ? 'checked': '' }}> Tecnico
					</label>
				</div>

				<div class="form-group col-sm-1">
					<label class="checkbox-inline" for="tipoactividad_cartera">
						<input type="checkbox" id="tipoactividad_cartera" name="tipoactividad_cartera" value="tipoactividad_cartera" disabled {{ $tipoactividad->tipoactividad_cartera ? 'checked': '' }}> Cartera
					</label>
				</div>
		    </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('tiposactividad.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('tiposactividad.edit', ['tiposactividad' => $tipoactividad->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
