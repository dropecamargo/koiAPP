@extends('tecnico.orden.main')

@section('module')
	<div id="ordenes-create"></div>

	<section id="orden-content-section">
	    <!-- Modal info remision -->
	    <div class="modal fade" id="modal-create-remision" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	        <div class="modal-dialog modal-lg" role="document">
	            <div class="modal-content">
	                <div class="modal-header small-box {{ config('koi.template.bg') }}">
	                    <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                    <h4><strong>Tecnico - Nueva remisión</strong></h4>
	                </div>
	                {!! Form::open(['id' => 'form-remrepu', 'data-toggle' => 'validator']) !!}
	                    <div class="modal-body" id="modal-remision-wrapper-show-info">
	                        <div class="content-modal">
	                        </div>
	                    </div>
	                {!! Form::close() !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm click-store-remsion">Continuar</button>
                    </div>
	            </div>
	        </div>
	    </div>
	    <!-- Modal info factura -->
	    <div class="modal fade" id="modal-create-factura" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	        <div class="modal-dialog modal-xlg" role="document">
	            <div class="modal-content">
	                <div class="modal-header small-box {{ config('koi.template.bg') }}">
	                    <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                    <h4 class="inner-title-modal modal-title">Tecnico - Nueva factura</h4>
	                </div>
	                    <div class="modal-body" id="modal-factura-wrapper-show-info">
	                        <div class="content-modal">
	                        </div>
	                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm click-store-factura">Continuar</button>
                    </div>
	            </div>
	        </div>
	    </div>

	    <script type="text/template" id="add-remision-tpl">
		    <div class="row">
		        <div class="form-group col-md-3">
		            <label for="remrepu2_serie" class="control-label">Producto</label>
		            <div class="input-group input-group-sm">
		                <span class="input-group-btn">
		                    <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="remrepu2_serie">
		                        <i class="fa fa-barcode"></i>
		                    </button>
		                </span>
		                <input id="remrepu2_serie" placeholder="Referencia" class="form-control producto-koi-component" name="remrepu2_serie" type="text" data-type="<%- tipoproducto %>" data-sucursal="<%- sucursal %>" maxlength="15" data-remision="true" data-wrapper="producto_create" data-name="remrepu2_nombre" required>
		            </div>
		        </div>
		        <div class="col-md-6 col-xs-10"><br>
		            <input id="remrepu2_nombre" name="remrepu2_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" readonly required>
		        </div>
		        <div class="form-group col-md-2">
		            <label for="remrepu2_cantidad" class="control-label">Cantidad</label>
		            <input type="number" name="remrepu2_cantidad" id="remrepu2_cantidad" min="1" class="form-control input-sm">
		        </div>
		        <div class="form-group col-md-1"><br>
		            <button type="button" class="btn btn-success btn-sm btn-block click-add-item">
		                <i class="fa fa-plus"></i>
		            </button>
		        </div>
		    </div>

		    <!-- table table-bordered table-striped -->
		    <div class="table-responsive no-padding">
		        <table id="browse-legalizacions-list" class="table table-hover table-bordered" cellspacing="0">
		            <thead>
		                <tr>
		                    <th width="5%"></th>
		                    <th width="10%">Referencia</th>
		                    <th width="40%">Nombre</th>
		                    <th width="10%">Cantidad</th>
		                </tr>
		            </thead>
		            <tbody>
		                {{-- Render content remrepu --}}
		            </tbody>
		        </table>
		    </div>
		</script>
		<script type="text/template" id="add-factura-tecnico-tpl">
            {!! Form::open(['id' => 'form-factura-tecnico', 'data-toggle' => 'validator']) !!}
				<div class="row">
					<label class="control-label col-md-1">Tercero</label>
					<div class="form-group col-md-11">
						<%- tercero_nombre %>
					</div>
				</div>
				<div class="row">
					<label class="control-label col-md-1">Contacto</label>
					<div class="form-group col-md-11">
						<%- tcontacto_nombre %>
					</div>
				</div>
	            <div class="row">
	                <label for="factura1_puntoventa" class="col-md-1 control-label">Punto Venta</label>
	                <div class="form-group col-md-6">
	                    <select name="factura1_puntoventa" id="factura1_puntoventa" class="form-control select2-default change-puntoventa-consecutive-koi-component" data-wrapper="factura-create" data-field="factura1_numero" >
	                        @foreach( App\Models\Base\PuntoVenta::getPuntosVenta() as $key => $value)
	                        	<option  value="{{ $key }}">{{ $value }}</option>
	                        @endforeach
	                    </select>
	                </div>
	                <label for="factura1_numero" class="col-md-1 control-label">Número</label>
	                <div class="form-group col-md-2">
	                    <input id="factura1_numero" name="factura1_numero" class="form-control input-sm" type="number" min="1" required readonly>
	                </div>
	            </div>
	            <div class="row">
	                <label for="factura1_sucursal" class="col-md-1 control-label">Sucursal</label>
	                <div class="form-group col-md-6">
	                    <select name="factura1_sucursal" id="factura1_sucursal" class="form-control select2-default-clear" >
	                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
	                        	<option  value="{{ $key }}">{{ $value }}</option>
	                        @endforeach
	                    </select>
	                </div>
	                <label for="factura1_fecha" class="col-md-1 control-label">Fecha</label>
	                <div class="form-group col-md-3">
	                    <div class="input-group">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                    	<input type="text" id="factura1_fecha" name="factura1_fecha" value="<%- moment().format('YYYY-MM-DD') %>" class="form-control input-sm datepicker" required>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <label for="factura1_formapago" class="col-md-1 control-label">Pago</label>
	                <div class="form-group col-md-2">
	                    <select name="factura1_formapago" id="factura1_formapago" class="form-control" required>
	                        @foreach( config('koi.produccion.formaspago') as $key => $value)
	                            <option value="{{ $key }}">{{ $value }}</option>
	                        @endforeach
	                    </select>
	                </div>
	                <label for="factura1_plazo" class="col-md-1 control-label">Plazo</label>
	                <div class="form-group col-md-1">
	                    <input id="factura1_plazo" name="factura1_plazo" class="form-control input-sm" type="number" min="0"  required>
	                </div>

	                <label for="factura1_cuotas" class="col-md-1 control-label">Cuotas</label>
	                <div class="form-group col-md-1">
	                    <input id="factura1_cuotas" name="factura1_cuotas" class="form-control input-sm" type="number" min="0" required>
	                </div>

	                <label for="factura1_primerpago" class="col-md-1 control-label">Primer Pago</label>
	                <div class="form-group col-md-3">
	                    <div class="input-group">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
							<input type="text" id="factura1_primerpago" name="factura1_primerpago" value="<%- moment().format('YYYY-MM-DD') %>" class="form-control input-sm datepicker" required>
	                    </div>

	                </div>
	            </div>
	            <div class="row">
	                <label for="factura1_vendedor" class="col-md-1 control-label">Vendedor</label>
	                <div class="form-group col-md-6">
	                    <select name="factura1_vendedor" id="factura1_vendedor" class="form-control select2-default">
	                        @foreach( App\Models\Base\Tercero::getSellers() as $key => $value)
	                        	<option  value="{{ $key }}">{{ $value }}</option>
	                        @endforeach
	                    </select>
	                </div>
	            </div>
	            <div class="row">
	                <div class="form-group col-md-12">
	                	<label for="factura1_observaciones" class="control-label">Observaciones</label>
	                    <textarea id="factura1_observaciones" name="factura1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
	                </div>
	            </div>
            {!! Form::close() !!}

            <div class="box-body box box-primary">
            	{!! Form::open(['id' => 'form-factura-tecnico-detail', 'data-toggle' => 'validator']) !!}
	                <div class="row">
	                    <label  class="control-label col-md-1 col-md-1">Producto</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group input-group-sm">
	                            <span class="input-group-btn">
	                                <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_serie">
	                                    <i class="fa fa-barcode"></i>
	                                </button>
	                            </span>
	                            <input id="producto_serie" placeholder="Serie" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="orden-content-section" data-name="producto_nombre" data-inventory="false" data-price="factura2_costo">
	                        </div>
	                    </div>
	                    <div class="form-group col-md-4">
	                        <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
	                    </div>

	                    <label for="factura2_cantidad" class="col-xs-6 col-md-1 col-md-1 control-label">Cantidad </label>
	                    <div class="col-xs-6 col-md-1 col-md-1 form-group">
	                        <input type="number" name="factura2_cantidad" id="factura2_cantidad"  class="form-control  input-sm" required min="0">
	                    </div>

	                    <label for="factura2_costo" class="col-xs-6 col-md-1 col-md-1 control-label">Precio </label>
	                    <div class="form-group col-xs-6 col-md-2">
	                        <input type="text" name="factura2_costo" id="factura2_costo" class="form-control input-sm" data-currency  required>
	                    </div>
	                </div>
	                <div class="row">
	                    <label class="col-xs-12 col-md-1 col-md-1 control-label">Descuento</label>
	                    <div class="form-group col-xs-8 col-md-1 col-md-1">
	                        <input type="text" id="factura2_descuento_porcentaje" name="factura2_descuento_porcentaje" class="spinner-percentage  input-sm form-control desc-porcentage" min="0"  max ="100" value="0" required>
	                    </div>
	                    <div class="col-xs-4 col-md-1 col-md-1">
	                        <label class="radio-inline without-padding">
	                            <input type="radio" id="desc_porcentage"  class="desc" checked name="radio_naturaleza_descuento"> <b>%</b>
	                        </label>
	                    </div>
	                    <div class="col-xs-8 col-md-2 col-md-2 form-group">
	                        <input type="text" id="factura2_descuento_valor" name="factura2_descuento_valor" value="0" class="form-control input-sm desc-value" data-currency-price required>
	                    </div>
	                    <div class="col-xs-4 col-md-1 col-md-1">
	                        <label class="radio-inline without-padding">
	                            <input type="radio" id="desc_value" class="desc" name="radio_naturaleza_descuento"> <b>Valor</b>
	                        </label>
	                    </div>

	                    <div class="form-group col-xs-8 col-md-2 col-md-2">
	                        <input type="text" id="factura2_precio_venta" name="factura2_precio_venta" value="0" class="form-control input-sm desc-finally" data-currency-price required>
	                    </div>
	                    <div class="col-xs-4 col-md-1 col-md-1">
	                        <label class="radio-inline without-padding">
	                            <input type="radio" id="desc_finally" class="desc" name="radio_naturaleza_descuento"> <b>Final</b>
	                        </label>
	                    </div>
	                    <label class="col-xs-12 col-md-1 col-md-1 control-label">Iva</label>
	                    <div class="form-group col-md-1 col-md-1">
	                        <input type="text" class="input-sm form-control spinner-percentage" min="0" id="factura2_iva_porcentaje" name="factura2_iva_porcentaje" required>
	                    </div>
	                    <div class="col-md-1 col-md-1">
	                        <button type="submit" class="btn btn-success btn-sm btn-block">
	                            <i class="fa fa-plus"></i>
	                        </button>
	                    </div>
	                </div>
            	{!! Form::close() !!}
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
		</script>
	</section>
@stop
