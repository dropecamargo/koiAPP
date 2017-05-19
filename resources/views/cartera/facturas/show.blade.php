@extends('cartera.facturas.main')

@section('breadcrumb')
    <li><a href="{{ route('facturas.index')}}">Facturas</a></li>
    <li class="active">{{ $factura->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body" id="factura-show">
            <div id="render-factura-show">
            	<div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">Fecha</label>
                        <div>{{ $factura->factura1_fh_elaboro }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Sucursal</label>
                        <div>{{ $factura->sucursal_nombre }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Número</label>
                        <div>{{ $factura->factura1_numero }}</div>
                    </div>
                    @if(!$factura->factura1_anulada)
                        <div class="form-group col-md-4">
                            <div class="dropdown pull-right">
                            <label class="label label-success">ESTADO: ACTIVO</label>
                                <a href="#" class="dropdown-toggle a-color" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="#" class="anular-factura">
                                            <i class="fa fa-ban"></i>Anular factura
                                        </a>
                                        <a role="menuitem" tabindex="-1" href="#" class="export-factura">
                                            <i class="fa fa-file-pdf-o"></i>Exportar
                                        </a>
                                    </li>
                                </ul>
                            </div>           
                        </div>
                    @else
                    <label class=" label label-default col-md-1  col-md-offset-2">ESTADO: ANULADA</label>
                    <div class="form-group col-md-1">
                        <button type="button" class="btn btn-block btn-danger btn-sm export-factura">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>    
                    </div>
                    @endif
                </div>
            	<div class="row">
    		        <div class="form-group col-md-12">
                        <label class="control-label">Cliente</label>
                        <div>{{ $factura->tercero_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $factura->factura1_tercero ]) }}" title="Ver tercero">{{ $factura->tercero_nit }} </a> </div>
                    </div>
            	</div>
            	<div class="row">
            		<div class="form-group col-md-2">
            			<label class="control-label">Bruto</label>
            			<div>$ {{number_format($factura->factura1_bruto)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Descuento</label>
            			<div>$ {{number_format($factura->factura1_descuento)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Iva</label>
            			<div>$ {{number_format($factura->factura1_iva)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Retencion</label>
            			<div>$ {{number_format($factura->factura1_retencion)}}</div>
            		</div>

            		<div class="form-group col-md-2">
            			<label class="control-label">Total</label>
            			<div>$ {{number_format($factura->factura1_total)}}</div>
            		</div>
            	</div>
            	<div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Cuotas</label>
                        <div>{{$factura->factura1_cuotas}}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Plazo</label>
                        <div>{{$factura->factura1_plazo}}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Fecha Primer Pago</label>
                        <div>{{$factura->factura1_primerpago}}</div>
                    </div>   
                </div>
            	<div class="row">
            		<div class="form-group col-md-12">
            			<label class="control-label"> Observaciones</label>
            			<div>{{ $factura->factura1_observaciones }}</div>
            		</div>
            	</div>
            	<div id="" class="box box-success">
		            <div class="table-responsive no-padding">
		                <table id="browse-detalle-factura-list" class="table table-hover table-bordered" cellspacing="0">
		                    <thead>
		                        <tr>
		                            <th width="10%">Referencia</th>
		                            <th width="35%">Nombre</th>
		                            <th width="3%">Cant</th>
		                            <th width="15%">Precio</th>
		                            <th width="15%">Descuento</th>
		                            <th width="9%">Iva</th>
		                            <th  width="10%">Total</th>
		                        </tr>
		                    </thead>
		                    <tfoot>
		                        <tr>
		                            <th colspan="3" class="text-right">Total: </th>
		                            <th id="precio-product"></th>
		                            <th id="descuento-product"></th>
		                            <th id="iva-product"></th>
		                            <th id="totalize-product"></th>
		                        </tr>
		                    </tfoot>

		                    <tbody>
		                        {{-- Render content detalle factura --}}
		                    </tbody>
		                </table>
            		</div>
            	</div>
                <div class="box box-success">
                    <div class="box-body table-responsive">
                        <table id="browse-factura3-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Cuota</th>
                                    <th>Vencimiento</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                </tr>
                           </thead>
                           <tbody>
                                {{-- Render factura3 list --}}
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>   
    <script type="text/template" id="factura-close-confirm-tpl">
        <p>¿Está seguro que desea cerrar la factura de venta número <b> <%- id %> </b>?</p>
    </script>     
@stop
