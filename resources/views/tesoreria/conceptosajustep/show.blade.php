@extends('tesoreria.conceptosajustep.main')

@section('breadcrumb')
    <li><a href="{{ route('conceptosajustep.index')}}">Concepto ajuste proveedor</a></li>
    <li class="active">{{ $conceptoajustep->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <label>Nombre</label>
                    <div>{{ $conceptoajustep->conceptoajustep_nombre }}</div>
                </div>
                <div class="col-sm-2 col-xs-8"><br>
                    <label class="checkbox-inline" for="conceptoajustep_activo">
                        <input type="checkbox" id="conceptoajustep_activo" name="conceptoajustep_activo" value="conceptoajustep_activo" disabled {{ $conceptoajustep->conceptoajustep_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('conceptosajustep.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('conceptosajustep.edit', ['conceptoajustep' => $conceptoajustep->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
