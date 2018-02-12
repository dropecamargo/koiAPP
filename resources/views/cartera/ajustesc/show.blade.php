@extends('cartera.ajustesc.main')

@section('breadcrumb')
    <li><a href="{{ route('ajustesc.index')}}">Ajuste cartera</a></li>
    <li class="active">{{ $ajustec->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="ajustec-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Código</label>
                    <div>{{ $ajustec->id }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $ajustec->ajustec1_fecha }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $ajustec->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Numero</label>
                    <div>{{ $ajustec->ajustec1_numero }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Cliente</label>
                    <div>{{ $ajustec->tercero_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Concepto</label>
                    <div>{{ $ajustec->conceptoajustec_nombre }}</div>
                </div>
                <div class="form-group col-md-8">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $ajustec->ajustec1_observaciones }}</div>
                </div>
            </div>

            <!-- table table-bordered table-striped -->
            <div class="box box-solid">
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-ajustec-list" class="table table-hover table-bordered" cellspacing="0">
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
                    <a href=" {{ route('ajustesc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
