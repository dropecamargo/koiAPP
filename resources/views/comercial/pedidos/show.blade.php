@extends('comercial.pedidos.main')

@section('breadcrumb')
    <li><a href="{{ route('pedidosc.index')}}">Pedidos comerciales</a></li>
    <li class="active">{{ $pedidoComercial->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body" id="pedidoc-show">
            <div id="render-pedidoc-show">
            	<div class="row">
                    <div class="form-group col-md-3 col-xs-6">
                        <label class="control-label">Fecha</label>
                        <div>{{ $pedidoComercial->pedidoc1_fecha }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Sucursal</label>
                        <div>{{ $pedidoComercial->sucursal_nombre }}</div>
                    </div>
                    <div class="form-group col-md-3 col-xs-5">
                        <label class="control-label">Número</label>
                        <div>{{ $pedidoComercial->pedidoc1_numero }}</div>
                    </div>
                    @if(!$pedidoComercial->pedidoc1_anular)
                        <div class="form-group col-md-3">
                            <div class="dropdown pull-right">
                                <label class="label label-success">ESTADO: ACTIVO</label>
                                <a href="#" class="dropdown-toggle a-color" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="#" class="anular-pedidoc">
                                            <i class="fa fa-ban"></i>Anular pedido
                                        </a>
                                        @if($pedidoComercial->pedidoc1_autorizacion_co == null)
                                            <a role="menuitem" tabindex="-1" href="#" class="authco-pedidoc">
                                                <i class="fa fa-gavel"></i>Autorizar comercial
                                            </a>
                                        @endif
                                        <a role="menuitem" tabindex="-1" href="#" class="export-pedidoc">
                                            <i class="fa fa-file-pdf-o"></i>Exportar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <label class=" label label-default">ESTADO: ANULADO</label>
                        <div class="form-group col-md-1 pull-right">
                            <button type="button" class="btn btn-block btn-danger btn-sm export-pedidoc">
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
                        </div>
                    @endif
            	</div>
            	<div class="row">
    		        <div class="form-group col-md-12">
                        <label class="control-label">Cliente</label>
                        <div>{{ $pedidoComercial->tercero_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $pedidoComercial->pedidoc1_tercero ]) }}" title="Ver tercero">{{ $pedidoComercial->tercero_nit }} </a> </div>
                    </div>
            	</div>
            	<div class="row">
            		<div class="form-group col-md-2 col-xs-6">
            			<label class="control-label">Bruto</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_bruto)}}</div>
            		</div>
            		<div class="form-group col-md-2 col-xs-6">
            			<label class="control-label">Descuento</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_descuento)}}</div>
            		</div>
            		<div class="form-group col-md-2 col-xs-6">
            			<label class="control-label">Iva</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_iva)}}</div>
            		</div>
            		<div class="form-group col-md-2 col-xs-6">
            			<label class="control-label">Retencion</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_retencion)}}</div>
            		</div>

            		<div class="form-group col-md-2 col-xs-6">
            			<label class="control-label">Total</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_total)}}</div>
            		</div>
            	</div>
            	<div class="row">
                    <div class="form-group col-md-2 col-xs-4">
                        <label class="control-label">Cuotas</label>
                        <div>{{$pedidoComercial->pedidoc1_cuotas}}</div>
                    </div>
                    <div class="form-group col-md-2 col-xs-4">
                        <label class="control-label">Plazo</label>
                        <div>{{$pedidoComercial->pedidoc1_plazo}}</div>
                    </div>
                    <div class="form-group col-md-2 col-xs-4">
                        <label class="control-label">F. Primer Pago</label>
                        <div>{{$pedidoComercial->pedidoc1_primerpago}}</div>
                    </div>
                </div>
            	<div class="row">
            		<div class="form-group col-md-12">
            			<label class="control-label"> Observaciones</label>
            			<div>{{ $pedidoComercial->pedidoc1_observaciones }}</div>
            		</div>
            	</div>
            	<div class="box box-primary">
		            <div class="table-responsive no-padding">
		                <table id="browse-detalle-pedidoc-list" class="table table-bordered" cellspacing="0">
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
		                        {{-- Render content detalle pedidoc --}}
		                    </tbody>
		                </table>
            		</div>
            	</div>
                <div class="box box-primary">
                    <div class="table table-responsive no-padding">
                        <table id="browse-detalle-authorizations-list" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">Item</th>
                                    <th width="60%">Observación</th>
                                    <th width="20%">Usuario</th>
                                    <th width="15%">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Render content authorizations--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                        <a href=" {{ route('pedidosc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/template" id="pedidoc-close-confirm-tpl">
        <p>¿Está seguro que desea cerrar el pedido comerical de venta número <b> <%- id %> </b>?</p>
    </script>
@stop
