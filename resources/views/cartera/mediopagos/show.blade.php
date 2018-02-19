@extends('cartera.mediopagos.main')

@section('breadcrumb')
    <li><a href="{{ route('mediopagos.index')}}">Medio de pago</a></li>
    <li class="active">{{ $mediopago->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Nombre</label>
                    <div>{{ $mediopago->mediopago_nombre }}</div>
                </div>
                <div class="form-group col-md-1 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="mediopago_activo">
                        <input type="checkbox" id="mediopago_activo" name="mediopago_activo" value="mediopago_activo" disabled {{ $mediopago->mediopago_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
                <div class="form-group col-md-1 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="mediopago_ef">
                        <input type="checkbox" id="mediopago_ef" name="mediopago_ef" value="mediopago_ef" disabled {{ $mediopago->mediopago_ef ? 'checked': '' }}> Efectivo
                    </label>
                </div>
                <div class="form-group col-md-1 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="mediopago_ch">
                        <input type="checkbox" id="mediopago_ch" name="mediopago_ch" value="mediopago_ch" disabled {{ $mediopago->mediopago_ch ? 'checked': '' }}> Cheque
                    </label>
                </div>
            </div>
        </div>
        
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('mediopagos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('mediopagos.edit', ['mediopagos' => $mediopago->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
