@extends('cartera.notas.main')

@section('breadcrumb')
    <li><a href="{{ route('notas.index')}}">Nota</a></li>
    <li class="active">{{ $nota->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="nota-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $nota->nota1_fecha }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $nota->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Número</label>
                    <div>{{ $nota->nota1_numero }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-5">
                    <label class="control-label">Cliente</label>
                    <div>{{ $nota->tercero_nombre }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Concepto</label>
                    <div>{{ $nota->conceptonota_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Valor</label>
                    <div>{{ number_format ($nota->nota1_valor,2,',' , '.') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $nota->nota1_observaciones }}</div>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6 text-left">
                        <a href=" {{ route('notas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                </div>
            </div>
            <!-- table table-bordered table-striped -->
            <div class="box-body table-responsive no-padding">
                <table id="browse-detalle-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="95px">Concepto</th>
                            <th width="95px">Documento</th>
                            <th width="95px">Número</th>
                            <th width="95px">Cuota</th>
                            <th width="95px">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                            {{-- Render content nota2 --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <th class="text-left">Total</th>
                            <th class="text-right" id="total">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                    <h4><a href="{{ route('asientos.show', ['asientos' =>  $nota->nota1_asiento ]) }}" target="_blanck" title="Ver Asiento"> Ver asiento contable </a></h4>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                    <h4><b>Nota de cartera N° {{$nota->nota1_numero}} </b></h4>
                </div>
            </div>
        </div>
    </div>
@stop
