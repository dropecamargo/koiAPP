@extends('inventario.tipoproducto.main')

@section('breadcrumb')
    <li><a href="{{ route('tiposproducto.index')}}">Tipos de producto</a></li>
    <li class="active">{{ $tipoproducto->tipoproducto_codigo }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $tipoproducto->tipoproducto_codigo }}</div>
                </div>
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipoproducto->tipoproducto_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="tipoproducto_activo">
                        <input type="checkbox" id="tipoproducto_activo" name="tipoproducto_activo" value="tipoproducto_activo" disabled {{ $tipoproducto->tipoproducto_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-footer">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tiposproducto.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('tiposproducto.edit', ['tipoproducto' => $tipoproducto->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
