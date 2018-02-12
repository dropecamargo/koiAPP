@extends('tesoreria.ajustesp.main')

@section('breadcrumb')
    <li><a href="{{ route('ajustesp.index')}}">Ajuste proveedor</a></li>
    <li class="active">{{ $ajustep->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="ajustep-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Código</label>
                    <div>{{ $ajustep->id }}</div>
                </div>

                <div class="form-group col-md-1 col-md-offset-8">
                    <button type="button" class="btn btn-block btn-danger btn-sm export-ajustep">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Regional</label>
                    <div>{{ $ajustep->regional_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Numero</label>
                    <div>{{ $ajustep->ajustep1_numero }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Cliente</label>
                    <div>{{ $ajustep->tercero_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Concepto</label>
                    <div>{{ $ajustep->conceptoajustep_nombre }}</div>
                </div>
                <div class="form-group col-md-8">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $ajustep->ajustep1_observaciones }}</div>
                </div>
            </div>

            <!-- table table-bordered table-striped -->
            <div class="box box-solid">
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-ajustep-list" class="table table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <td colspan="4"></td>
                                <th colspan="2" class="text-center">Naturaleza</th>
                            </tr>
                            <tr>
                                <th width="95px">Tercero</th>
                                <th width="95px">Documento</th>
                                <th width="95px">Numero</th>
                                <th width="95px">Cuota</th>
                                <th width="95px">Debito</th>
                                <th width="95px">Credito</th>
                            </tr>
                        </thead>
                        <tbody>
                                {{-- Render content recibo2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <th class="text-left">Total</th>
                                <th class="text-right" id="total-debito">0</th>
                                <th class="text-right" id="total-credito">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('ajustesp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
