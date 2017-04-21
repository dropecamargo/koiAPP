@extends('inventario.ajustes.main')

@section('breadcrumb')
    <li><a href="{{ route('ajustes.index')}}">Ajustes</a></li>
    <li class="active">{{ $ajuste1->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body" id="ajuste-show">
            <div id="render-ajuste-show">
                <div class="row"> 
                    <div class="form-group col-md-3">
                        <label class="control-label">Fecha</label>
                        <div>{{ $ajuste1->ajuste1_fecha }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Sucursal</label>
                        <div>{{ $ajuste1->sucursal_nombre }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Número</label>
                        <div>{{ $ajuste1->ajuste1_numero }}</div>
                    </div>
                </div>
                <div class="row"> 
                     <div class="form-group col-md-3">
                        <label class="control-label">Tipo Ajuste</label>
                        <div>{{ $ajuste1->tipoajuste_nombre }}</div>
                    </div> 
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label class="control-label">Obsercaciones</label>
                        <div>{{ $ajuste1->ajuste1_observaciones }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label class="control-label">Elaboró: </label>
                        <div>
                            <a href="{{ route('terceros.show', ['terceros' =>  $ajuste1->ajuste1_usuario_elaboro ]) }}" title="Ver tercero">{{ $ajuste1->tercero_nit }} </a> - {{ $ajuste1->tercero_nombre }}
                        </div>
                    </div>
                </div>
                <div id="detalle-ajuste" class="box box-success">
                    <div class="table-responsive no-padding">
                        <table id="browse-detalle-ajuste-list" class="table table-hover table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="15%">Referencia</th>
                                    <th width="40%" align="left">Nombre</th>
                                    <th width="15%" align="left">Nombre Lote</th>
                                    <th width="10%">Cant. Entrada</th>
                                    <th width="10%">Cant. Salida</th>
                                    <th width="10%">Costo</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Render content detalle ajuste --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('ajustes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop