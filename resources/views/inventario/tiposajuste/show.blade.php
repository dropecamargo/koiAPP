@extends('inventario.tiposajuste.main')

@section('breadcrumb')
<li><a href="{{route('tiposajuste.index')}}">Tipo de ajuste</a></li>
<li class="active">{{ $tipoajuste->id }}</li>
@stop

@section('module')
<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-8">
                <label class="control-label">Nombre</label>
                <div>{{ $tipoajuste->tipoajuste_nombre }}</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">Sigla</label>
                <div>{{ $tipoajuste->tipoajuste_sigla }}</div>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Tipo</label>
                <div>{{ $tipoajuste->tipoajuste_tipo }}</div>
            </div>
            <div class="form-group col-md-2">
                 <label class="checkbox-inline" for="tipoajuste_activo">
                        <input type="checkbox" id="tipoajuste_activo" name="tipoajuste_activo" value="tipoajuste_activo" disabled {{ $tipoajuste->tipoajuste_activo  ? 'checked': '' }}> Activo
                </label>
            
            </div>
        </div>
    </div>
    <div class="box-footer with-border">
        <div class="row">
            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                <a href=" {{ route('tiposajuste.index')}} " class="btn btn-default btn-sm btn-block"> {{ trans('app.comeback') }}</a>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                <a href=" {{ route('tiposajuste.edit', ['tipoajuste' => $tipoajuste->id])}}" class="btn btn-primary btn-sm btn-block">{{trans('app.edit')}}</a>
            </div>
        </div>
    </div>
</div>
@stop
