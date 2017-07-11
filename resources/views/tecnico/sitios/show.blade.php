@extends('tecnico.sitios.main')

@section('breadcrumb')
    <li><a href="{{ route('sitios.index')}}">Sitios</a></li>
    <li class="active">{{ $sitio->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $sitio->id }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $sitio->sitio_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="sitio_activo">
                        <input type="checkbox" id="sitio_activo" name="sitio_activo" value="sitio_activo" disabled {{ $sitio->sitio_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('sitios.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('sitios.edit', ['sitios' => $sitio->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop