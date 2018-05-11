@extends('admin.puntosventa.main')

@section('breadcrumb')
    <li><a href="{{ route('puntosventa.index')}}">Punto de venta</a></li>
    <li class="active">{{ $puntoventa->puntoventa_prefijo }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $puntoventa->puntoventa_nombre }}</div>
                </div>
                <div class="form-group col-sm-2">
                    <label class="control-label">Prefijo</label>
                    <div>{{ $puntoventa->puntoventa_prefijo }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label class="control-label">Resolución de facturación DIAN</label>
                    <div>{{ $puntoventa->puntoventa_resolucion_dian }}</div>
                </div>
                <div class="form-group col-sm-2">
                    <label class="control-label">Consecutivo</label>
                    <div>{{ $puntoventa->puntoventa_numero }}</div>
                </div>
                <div class="form-group col-sm-4">
                    <label class="control-label">Detalle N° cuenta</label>
                    <div>{{ $puntoventa->puntoventa_observacion }}</div>
                </div>
                <div class="form-group col-sm-2"><br>
                    <label class="checkbox-inline" for="puntoventa_activo">
                        <input type="checkbox" id="puntoventa_activo" name="puntoventa_activo" value="puntoventa_activo" disabled {{ $puntoventa->puntoventa_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="control-label">Encabezado</label>
                    <div>{{ $puntoventa->puntoventa_frase }}</div>
                </div>
                <div class="form-group col-sm-6">
                    <label class="control-label">Frase</label>
                    <div>{{ $puntoventa->puntoventa_frase }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="control-label">Pie de firma 1</label>
                    <div>{{ $puntoventa->puntoventa_footer1 }}</div>
                </div>
                <div class="form-group col-sm-6">
                    <label class="control-label">Pie de firma 2</label>
                    <div>{{ $puntoventa->puntoventa_footer2 }}</div>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('puntosventa.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('puntosventa.edit', ['puntosventa' => $puntoventa->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
