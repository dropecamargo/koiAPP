@extends('inventario.ajustes.main')

@section('breadcrumb')
    <li><a href="{{ route('ajustes.index')}}">Ajustes</a></li>
    <li class="active">{{ $ajuste1->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body" id="ajuste-show">
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
                <div class="form-group col-md-3">
                    <div class="dropdown pull-right">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Opciones <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                @if($ajuste1->tipoajuste_tipo == 'S')
                                    <a role="menuitem" tabindex="-1" href="#" class="export-alistar">
                                        <i class="fa fa-file-pdf-o"></i>Alistamiento
                                    </a>
                                @endif
                                <a role="menuitem" tabindex="-1" href="#" class="export-ajuste">
                                    <i class="fa fa-file-pdf-o"></i>Exportar
                                </a>
                            </li>
                        </ul>
                    </div>
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
                        {{ $ajuste1->tercero_nombre }} <br>Doumento: <a href="{{ route('terceros.show', ['terceros' =>  $ajuste1->ajuste1_usuario_elaboro ]) }}" title="Ver tercero">{{ $ajuste1->tercero_nit }} </a>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <table id="browse-detalle-ajuste-list" class="table table-bordered table-condensed" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="15%">Referencia</th>
                                <th>Nombre</th>
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
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('ajustes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
