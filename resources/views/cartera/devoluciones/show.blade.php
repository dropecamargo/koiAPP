@extends('cartera.devoluciones.main')

@section('breadcrumb')
    <li><a href="{{ route('devoluciones.index')}}">Devolución</a></li>
    <li class="active">{{ $devolucion->id }}</li>
@stop

@section('module')
	<div class="box box-success">
		<div class="box-body" id="devolucion-show">
			<div id="render-devolucion-show">
				<div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">Fecha</label>
                        <div>{{ $devolucion->devolucion1_fh_elaboro }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Sucursal</label>
                        <div>{{ $devolucion->sucursal_nombre }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Número</label>
                        <div>{{ $devolucion->devolucion1_numero }}</div>
                    </div>
				</div>
            	<div class="row">
    		        <div class="form-group col-md-12">
                        <label class="control-label">Cliente</label>
                        <div>{{ $devolucion->tercero_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $devolucion->devolucion1_tercero ]) }}" title="Ver tercero">{{ $devolucion->tercero_nit }} </a> </div>
                    </div>
            	</div>
            	<div class="row">
            		<div class="form-group col-md-2">
            			<label class="control-label">Bruto</label>
            			<div>$ {{number_format($devolucion->devolucion1_bruto)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Descuento</label>
            			<div>$ {{number_format($devolucion->devolucion1_descuento)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Iva</label>
            			<div>$ {{number_format($devolucion->devolucion1_iva)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Retencion</label>
            			<div>$ {{number_format($devolucion->devolucion1_retencion)}}</div>
            		</div>

            		<div class="form-group col-md-2">
            			<label class="control-label">Total</label>
            			<div>$ {{number_format($devolucion->devolucion1_total)}}</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="form-group col-md-12">
            			<label class="control-label"> Observaciones</label>
            			<div>{{ $devolucion->devolucion1_observaciones }}</div>
            		</div>
            	</div>
			</div>
			<div class="box box-success">
				<div class="table-responsive no-padding">
	                <table id="browse-detalle-devolucion-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="15%">Referencia</th>
                            <th width="30%">Nombre</th>
                            <th width="10%">Cantidad</th>
                            <th width="15%">Precio</th>
                            <th width="15%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{--Render content detalle--}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">Totales</th>
                            <th id="total_devueltas"> </th>
                            <th id="total_price"></th>
                            <th id="total"></th>
                        </tr>
                    </tfoot>
                </table>
				</div>
			</div>
		</div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('devoluciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
	</div>
@stop
