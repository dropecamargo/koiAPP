@extends('inventario.tipostraslados.main')

@section('breadcrumb')
<li><a href="{{route('tipostraslados.index')}}">Tipo Traslado</a></li>
<li class="active">{{ $tipotraslado->id }}</li>
@stop

@section('module')
<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-8">
                <label class="control-label">Nombre</label>
                <div>{{ $tipotraslado->tipotraslado_nombre }}</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">Sigla</label>
                <div>{{ $tipotraslado->tipotraslado_sigla }}</div>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Tipo</label>
                <div>{{ $tipotraslado->tipotraslado_tipo }}</div>
            </div>
            <div class="form-group col-md-2">
                 <label class="checkbox-inline" for="tipotraslado_activo">
                        <input type="checkbox" id="tipotraslado_activo" name="tipotraslado_activo" value="tipotraslado_activo" disabled {{ $tipotraslado->tipotraslado_activo  ? 'checked': '' }}> Activo
                </label>
            
            </div>
        </div>
    </div>
    <div class="box-footer with-border">
        <div class="row">
            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                <a href=" {{ route('tipostraslados.index')}} " class="btn btn-default btn-sm btn-block"> {{ trans('app.comeback') }}</a>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                <a href=" {{ route('tipostraslados.edit', ['tipotraslado' => $tipotraslado])}}" class="btn btn-primary btn-sm btn-block">{{trans('app.edit')}}</a>
            </div>
        </div>
    </div>
</div>
@stop
