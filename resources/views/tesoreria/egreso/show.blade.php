@extends('tesoreria.egreso.main')

@section('breadcrumb')
    <li><a href="{{ route('egresos.index')}}">Egreso</a></li>
    <li class="active">{{ $egreso->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="egreso-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Código</label>
                    <div>{{ $egreso->id }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $egreso->egreso1_fecha }}</div>
                </div>
                @if(!$egreso->egreso1_anulado)
                    <div class="form-group col-md-7">
                        <div class="dropdown pull-right">
                            <label class="label label-success">ESTADO: ACTIVO</label>
                            <a href="#" class="dropdown-toggle a-color" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="#" class="anular-egreso">
                                        <i class="fa fa-ban"></i>Anular
                                    </a>
                                    <a role="menuitem" tabindex="-1" href="#" class="export-egreso">
                                        <i class="fa fa-file-pdf-o"></i>Exportar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <label class=" label label-default col-md-1  col-md-offset-5">ESTADO: ANULADA</label>
                    <div class="form-group col-md-1">
                        <button type="button" class="btn btn-block btn-danger btn-sm export-egreso">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                    </div>
                @endif

            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Regional</label>
                    <div>{{ $egreso->regional_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Numero</label>
                    <div>{{ $egreso->egreso1_numero }}</div>
                </div>
            </div>
            <div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Cuenta</label>
                    <div>{{ $egreso->cuentabanco_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">N° cheque</label>
                    <div>{{ $egreso->egreso1_numero_cheque }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha cheque</label>
                    <div>{{ $egreso->egreso1_fecha_cheque }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Valor cheque</label>
                    <div>{{ number_format($egreso->egreso1_valor_cheque) }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Cliente</label>
                    <div>{{ $egreso->tercero_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $egreso->egreso1_observaciones }}</div>
                </div>
            </div>
            <br>
            <!-- table table-bordered table-striped -->
            <div class="box-body table-responsive no-padding">
                <table id="browse-egreso2-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                            {{-- Render content egreso2 --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('egresos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/template" id="egreso-anular-confirm-tpl">
        <p>¿Está seguro que desea anular el egreso número <b> <%- id %> </b>?</p>
    </script>
@stop
