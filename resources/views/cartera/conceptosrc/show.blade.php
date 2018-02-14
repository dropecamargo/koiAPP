@extends('cartera.conceptosrc.main')

@section('breadcrumb')
    <li><a href="{{ route('conceptosrc.index')}}">Concepto recibo de caja</a></li>
    <li class="active">{{ $conceptosrc->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12 col-xs-12 col-sm-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $conceptosrc->conceptosrc_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-xs-12 col-sm-6">
                    <label class="control-label">Documento</label>
                    <div>{{ $conceptosrc->documentos_nombre }}</div>
                </div>
                <div class="form-group col-md-2 col-xs-6 col-sm-3"><br>
                    <label class="checkbox-inline" for="conceptosrc_activo">
                        <input type="checkbox" id="conceptosrc_activo" name="conceptosrc_activo" value="conceptosrc_activo" disabled {{ $conceptosrc->conceptosrc_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('conceptosrc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('conceptosrc.edit', ['conceptosrc' => $conceptosrc->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
