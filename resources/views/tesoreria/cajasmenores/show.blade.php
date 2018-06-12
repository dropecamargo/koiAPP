@extends('tesoreria.cajasmenores.main')

@section('breadcrumb')
    <li><a href="{{ route('cajasmenores.index')}}">Caja Menor</a></li>
    <li class="active">{{ $cajaMenor1->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="cajamenor-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Regional</label>
                    <div>{{ $cajaMenor1->regional_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Número</label>
                    <div>{{ $cajaMenor1->cajamenor1_numero }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $cajaMenor1->cajamenor1_fecha }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Empleado</label>
                    <div>{{ $cajaMenor1->tercero_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $cajaMenor1->cajamenor1_tercero ]) }}" target="_blanck" title="Ver Empleado">{{ $cajaMenor1->tercero_nit }}</a></div>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-md-4">
                    <label class="control-label">Cuenta de banco</label>
                    <div>{{ $cajaMenor1->cuentabanco_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Efectivo</label>
                    <div>{{ number_format ($cajaMenor1->cajamenor1_efectivo,2,',' , '.') }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Provisional</label>
                    <div>{{ number_format ($cajaMenor1->cajamenor1_provisionales,2,',' , '.') }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Reembolso</label>
                    <div>{{ number_format ($cajaMenor1->cajamenor1_reembolso,2,',' , '.') }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fondo</label>
                    <div>{{ number_format ($cajaMenor1->cajamenor1_fondo,2,',' , '.') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $cajaMenor1->cajamenor1_observaciones }}</div>
                </div>
            </div>

            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                        <a href=" {{ route('cajasmenores.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                </div>
            </div>
            <!-- table table-bordered table-striped -->
            <div class="box box-solid">
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-cajamenor-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="30%">Concepto</th>
                                <th width="30%">Tercero</th>
                                <th width="15%">Cuenta</th>
                                <th width="15%">Centro Costo</th>
                                <th width="10%">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                                {{-- Render content cajamenor2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</td>
                                <th class="text-right"  id="total-valor">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                    <h4><a href="{{ route('asientos.show', ['asientos' =>  $cajaMenor1->cajamenor1_asiento ]) }}" target="_blanck" title="Ver Asiento"> Ver asiento contable </a></h4>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                    <h4><b>Caja Menor N° {{$cajaMenor1->cajamenor1_numero}} </b></h4>
                </div>
            </div>
        </div>
    </div>
@stop
