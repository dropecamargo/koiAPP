@extends('inventario.trasladosubicaciones.main')

@section('breadcrumb')
    <li><a href="{{ route('trasladosubicaciones.index')}}">Traslado de ubicación</a></li>
    <li class="active">{{ $trasladou->trasladou1_numero }}</li>
@stop

@section('module')
    <div class="box box-primary" id="trasladosubicaciones-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $trasladou->sucursal_nombre }}</div>
                </div>
                
                <div class="form-group col-md-3">
                    <label class="control-label">Número</label>
                    <div>{{ $trasladou->trasladou1_numero }}</div>
                </div>

                <div class="form-group col-md-1 col-sm-1 pull-right">
                    <button type="button" class="btn btn-block btn-danger btn-sm export-trasladoubicacion">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Ubicación origen</label>
                    <div>{{ $trasladou->origen }}</div>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label">Ubicación destino</label>
                    <div>{{ $trasladou->destino }}</div>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $trasladou->trasladou1_fecha }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Detalle</label>
                    <div>{{ $trasladou->trasladou1_observaciones }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Elaboró</label>
                    <div>Fecha: {{ $trasladou->trasladou1_fh_elaboro }}</div>
                    <a href="{{ route('terceros.show', ['terceros' =>  $trasladou->trasladou1_usuario_elaboro ]) }}" title="Ver tercero">
                        {{ $trasladou->username_elaboro }}
                    </a>
                </div>
            </div>

            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-2 col-sm-6 col-md-offset-5 col-xs-6 text-left">
                        <a href=" {{ route('trasladosubicaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                </div>
            </div>

            <div class="box box-primary table-responsive">
                <table id="browse-detalle-trasladou-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
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
