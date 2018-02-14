@extends('tesoreria.retefuente.main')

@section('breadcrumb')
    <li><a href="{{ route('retefuentes.index')}}">Retención en la fuente</a></li>
    <li class="active">{{ $retefuente->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-5">
                    <label class="control-label">Nombre</label>
                    <div>{{ $retefuente->retefuente_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3">
                    <label class="checkbox-inline" for="retefuentes_activo">
                        <input type="checkbox" id="retefuentes_activo" name="retefuentes_activo" value="retefuentes_activo" disabled {{ $retefuente->retefuente_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('retefuentes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('retefuentes.edit', ['retefuentes' => $retefuente->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
