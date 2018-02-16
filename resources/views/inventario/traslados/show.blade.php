@extends('inventario.traslados.main')

@section('breadcrumb')
    <li><a href="{{ route('traslados.index')}}">Traslado</a></li>
    <li class="active">{{ $traslado->traslado1_numero }}</li>
@stop

@section('module')
    <div class="box box-primary" id="traslados-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3 col-sm-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $traslado->traslado1_fecha }}</div>
                </div>

                <div class="form-group col-md-3 col-sm-3">
                    <label class="control-label">Número</label>
                    <div>{{ $traslado->traslado1_numero }}</div>
                </div>
                <div class="form-group col-md-1 col-sm-1 pull-right">
                    <button type="button" class="btn btn-block btn-danger btn-sm export-traslado">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3 col-sm-6">
                    <label class="control-label">Origen</label>
                    <div>{{ $traslado->origen }}</div>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label class="control-label">Destino</label>
                    <div>{{ $traslado->destino }}</div>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <label class="control-label">Tipo</label>
                    <div>{{ $traslado->tipotraslado_nombre }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 col-sm-12">
                    <label class="control-label">Detalle</label>
                    <div>{{ $traslado->traslado1_observaciones }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3 col-sm-6">
                    <label class="control-label">Elaboró</label>
                    <div>Fecha: {{ $traslado->traslado1_fh_elaboro }}</div>
                    <a href="{{ route('terceros.show', ['terceros' =>  $traslado->traslado1_usuario_elaboro ]) }}" title="Ver tercero">
                        {{ $traslado->username_elaboro }}
                    </a>
                </div>
            </div>

            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-2 col-sm-12 col-md-offset-5 col-xs-6 text-left">
                        <a href=" {{ route('traslados.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                </div>
            </div>

            <div class="box box-primary table-responsive">
                <table id="browse-detalle-traslado-list" class="table table-bordered" cellspacing="0" width="100%">
                    <tr>
                        <th>Serie</th>
                        <th>Producto</th>
                        <th>Unidades</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop
