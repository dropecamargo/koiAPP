@extends('inventario.unidades.main')

@section('breadcrumb')
    <li><a href="{{ route('unidades.index')}}">Unidad de medida</a></li>
    <li class="active">{{ $unidad->unidadmedida_sigla }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $unidad->unidadmedida_sigla }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $unidad->unidadmedida_nombre }}</div>
                </div>
                <br>
                <div class="form-group col-md-1">
                    <label class="checkbox-inline" for="unidad_medida_activo">
                    <input type="checkbox" id="unidad_medida_activo" name="unidad_medida_activo" value="unidad_medida_activo" disabled {{ $unidad->unidad_medida_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('unidades.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('unidades.edit', ['unidades' => $unidad->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
