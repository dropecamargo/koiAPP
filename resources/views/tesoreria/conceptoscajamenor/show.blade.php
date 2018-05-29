@extends('tesoreria.conceptoscajamenor.main')

@section('breadcrumb')
    <li><a href="{{ route('conceptoscajamenor.index')}}">Concepto caja menor</a></li>
    <li class="active">{{ $conceptocajamenor->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <label>Nombre</label>
                    <div>{{ $conceptocajamenor->conceptocajamenor_nombre }}</div>
                </div>
                <div class="col-sm-2 col-xs-8"><br>
                    <label class="checkbox-inline" for="conceptocajamenor_activo">
                        <input type="checkbox" id="conceptocajamenor_activo" name="conceptocajamenor_activo" value="conceptocajamenor_activo" disabled {{ $conceptocajamenor->conceptocajamenor_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label>Cuenta administrativa</label>
                    <div>{{ $conceptocajamenor->cuenta_administrativa }}</div>
                </div>
                <div class="col-sm-6">
                    <label>Cuenta ventas</label>
                    <div>{{ $conceptocajamenor->cuenta_ventas}}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('conceptoscajamenor.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('conceptoscajamenor.edit', ['conceptocajamenor' => $conceptocajamenor->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
