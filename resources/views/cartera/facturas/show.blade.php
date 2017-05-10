@extends('cartera.facturas.main')

@section('breadcrumb')
    <li><a href="{{ route('facturas.index')}}">Facturas</a></li>
    <li class="active">{{ $pedidoComercial->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body" id="pedidoc-show">
            <div id="render-pedidoc-show">
            	<div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">Fecha</label>
                        <div>{{ $pedidoComercial->pedidoc1_fecha }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Sucursal</label>
                        <div>{{ $pedidoComercial->sucursal_nombre }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Número</label>
                        <div>{{ $pedidoComercial->pedidoc1_numero }}</div>
                    </div>
            	</div>
            	<div class="row">
    		        <div class="form-group col-md-12">
                        <label class="control-label">Cliente</label>
                        <div>{{ $pedidoComercial->tercero_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $pedidoComercial->pedidoc1_tercero ]) }}" title="Ver tercero">{{ $pedidoComercial->tercero_nit }} </a> </div>
                    </div>
            	</div>
            	<div class="row">
            		<div class="form-group col-md-2">
            			<label class="control-label">Bruto</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_bruto)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Descuento</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_descuento)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Iva</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_iva)}}</div>
            		</div>
            		<div class="form-group col-md-2">
            			<label class="control-label">Retencion</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_retencion)}}</div>
            		</div>

            		<div class="form-group col-md-2">
            			<label class="control-label">Total</label>
            			<div>$ {{number_format($pedidoComercial->pedidoc1_total)}}</div>
            		</div>
            	</div>
            	<div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Cuotas</label>
                        <div>{{$pedidoComercial->pedidoc1_cuotas}}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Plazo</label>
                        <div>{{$pedidoComercial->pedidoc1_plazo}}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Fecha Primer Pago</label>
                        <div>{{$pedidoComercial->pedidoc1_primerpago}}</div>
                    </div>   
                </div>
            	<div class="row">
            		<div class="form-group col-md-12">
            			<label class="control-label"> Observaciones</label>
            			<div>{{ $pedidoComercial->pedidoc1_observaciones }}</div>
            		</div>
            	</div>
            	<div id="" class="box box-success">
		            <div class="table-responsive no-padding">
		                <table id="browse-detalle-pedidoc-list" class="table table-hover table-bordered" cellspacing="0">
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
            </div>
        </div>
    </div>        
@stop