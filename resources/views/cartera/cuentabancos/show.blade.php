@extends('cartera.cuentabancos.main')

@section('breadcrumb')
    <li><a href="{{ route('cuentabancos.index')}}">Cuenta de banco</a></li>
    <li class="active">{{ $cuentabanco->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $cuentabanco->cuentabanco_nombre }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Numero</label>
                    <div>{{ $cuentabanco->cuentabanco_numero }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Banco</label>
                    <div>{{ $cuentabanco->banco_nombre }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Plan de cuentas</label>
                    <div>{{ $cuentabanco->plancuentas_cuenta }} - {{ $cuentabanco->plancuentas_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="cuentabanco_activa">
                        <input type="checkbox" id="cuentabanco_activa" name="cuentabanco_activa" value="cuentabanco_activo" disabled {{ $cuentabanco->cuentabanco_activa ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('cuentabancos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('cuentabancos.edit', ['cuentabancos' => $cuentabanco->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
