@extends('cartera.conceptosajustec.main')

@section('breadcrumb')
    <li><a href="{{ route('conceptosajustec.index')}}">Concepto ajuste de cartera</a></li>
    <li class="active">{{ $conceptoajustec->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $conceptoajustec->conceptoajustec_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Plan de cuenta</label>
                    <div>{{ $conceptoajustec->plancuentas_cuenta }} - {{ $conceptoajustec->plancuentas_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="conceptoajustec_activo">
                        <input type="checkbox" id="conceptoajustec_activo" name="conceptoajustec_activo" value="conceptoajustec_activo" disabled {{ $conceptoajustec->conceptoajustec_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
                <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="conceptoajustec_sumas_iguales">
                        <input type="checkbox" id="conceptoajustec_sumas_iguales" name="conceptoajustec_sumas_iguales" value="conceptoajustec_sumas_iguales" disabled {{ $conceptoajustec->conceptoajustec_sumas_iguales ? 'checked': '' }}> Sumas iguales
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('conceptosajustec.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('conceptosajustec.edit', ['conceptoajustec' => $conceptoajustec->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
