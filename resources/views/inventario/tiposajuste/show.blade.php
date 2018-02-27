@extends('inventario.tiposajuste.main')

@section('breadcrumb')
<li><a href="{{route('tiposajuste.index')}}">Tipo de ajuste</a></li>
<li class="active">{{ $tipoajuste->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="tipoajuste-show">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2">
                    <label>Sigla</label>
                    <div>{{ $tipoajuste->tipoajuste_sigla }}</div>
                </div>
                <div class="col-sm-8">
                    <label>Nombre</label>
                    <div>{{ $tipoajuste->tipoajuste_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label>Tipo</label>
                    <div>{{ config('koi.tipoinventario')[$tipoajuste->tipoajuste_tipo] }}</div>
                </div><br>
                <div class="col-sm-2">
                     <label class="checkbox-inline" for="tipoajuste_activo">
                            <input type="checkbox" id="tipoajuste_activo" name="tipoajuste_activo" value="tipoajuste_activo" disabled {{ $tipoajuste->tipoajuste_activo  ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('tiposajuste.index')}} " class="btn btn-default btn-sm btn-block"> {{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('tiposajuste.edit', ['tipoajuste' => $tipoajuste->id])}}" class="btn btn-primary btn-sm btn-block">{{trans('app.edit')}}</a>
                </div>
            </div>
        </div><br>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table-responsive no-padding">
                            <table id="browse-detalle-tipoajuste-list" class="table table-bordered" cellspacing="0" width="100%">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
