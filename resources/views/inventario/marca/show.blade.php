@extends('inventario.marca.main')

@section('breadcrumb')
    <li><a href="{{ route('marcas.index')}}">Marcas</a></li>
    <li class="active">{{ $marca->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $marca->id }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $marca->marca_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3">
                    <label class="checkbox-inline" for="marca_activo">
                        <input type="checkbox" id="marca_activo" name="marca_activo" value="marca_activo" disabled {{ $marca->marca_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('marcas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('marcas.edit', ['marcas' => $marca->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop