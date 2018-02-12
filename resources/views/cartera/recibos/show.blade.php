@extends('cartera.recibos.main')

@section('breadcrumb')
    <li><a href="{{ route('recibos.index')}}">Recibo</a></li>
    <li class="active">{{ $recibo->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="recibo-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Código</label>
                    <div>{{ $recibo->id }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $recibo->recibo1_fecha }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha de pago</label>
                    <div>{{ $recibo->recibo1_fecha_pago }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $recibo->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Numero</label>
                    <div>{{ $recibo->recibo1_numero }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Cuenta</label>
                    <div>{{ $recibo->cuentabanco_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Cliente</label>
                    <div>{{ $recibo->tercero_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $recibo->recibo1_observaciones }}</div>
                </div>
            </div>
            <br>
            <!-- table table-bordered table-striped -->
            <div class="box-body table-responsive no-padding">
                <table id="browse-recibo-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="95px">Concepto</th>
                            <th width="95px">Documento</th>
                            <th width="95px">Numero</th>
                            <th width="95px">Cuota</th>
                            <th width="95px">Naturaleza</th>
                            <th width="95px">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                            {{-- Render content recibo2 --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <th class="text-left">Total</th>
                            <th class="text-right" id="total">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- table table-bordered table-striped --><br>
            <div class="box-body table-responsive no-padding">
                <table table id="browse-recibo3-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Medio de pago</th>
                            <th>Banco</th>
                            <th>Numero</th>
                            <th>Fecha</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Render content recibo3 --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3"></th>
                            <th class="text-left">Total</th>
                            <th class="text-right"  id="total">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('recibos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
