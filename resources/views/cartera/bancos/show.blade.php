@extends('cartera.bancos.main')

@section('breadcrumb')
    <li><a href="{{ route('bancos.index')}}">Banco</a></li>
    <li class="active">{{ $banco->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $banco->banco_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="banco_activo">
                        <input type="checkbox" id="banco_activo" name="banco_activo" value="banco_activo" disabled {{ $banco->banco_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('bancos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('bancos.edit', ['bancos' => $banco->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
