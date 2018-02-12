@extends('tecnico.tipoorden.main')

@section('breadcrumb')
    <li><a href="{{ route('tiposorden.index')}}">Tipo de orden</a></li>
    <li class="active">{{ $tipoorden->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipoorden->tipoorden_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="tipoorden_activo">
                        <input type="checkbox" id="tipoorden_activo" name="tipoorden_activo" value="tipoorden_activo" disabled {{ $tipoorden->tipoorden_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tiposorden.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('tiposorden.edit', ['tiposorden' => $tipoorden->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
