<!-- Modal add resource -->
<div class="modal fade" id="modal-add-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-create-resource-component">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-create-resource-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div id="error-resource-component" class="alert alert-danger"></div>
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- Modal search contacto -->
<div class="modal fade" id="modal-search-contacto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Buscador de contactos</h4>
			</div>
			<div class="content-modal"></div>
		</div>
	</div>
</div>
<!-- Modal inventario -->
<div class="modal fade" id="modal-inventario-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			
			<form id="form-create-inventario-entrada-component-source" data-toggle="validator">
				<div class="modal-body" id="modal-wrapper-inventario">
					<div id="error-inventario" class="alert alert-danger"></div>
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm" id="button-koi-inventory-modal">Continuar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal add tcontacto -->
<div class="modal fade" id="modal-tcontacto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-tcontacto-component">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Contactos</h4>
			</div>
			{!! Form::open(['id' => 'form-tcontacto-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- Modal address -->
<div class="modal fade" id="modal-address-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-address-component-validacion" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search -->
<div class="modal fade" id="modal-search-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search producto -->
<div class="modal fade" id="modal-search-producto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Buscador de productos</h4>
			</div>
			<div class="content-modal"></div>
		</div>
	</div>
</div>	

<!-- Modal search pedidoc -->
<div class="modal fade" id="modal-search-pedidoc-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Pedidos comerciales</h4>
			</div>
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal concepto-factura -->
<div class="modal fade" id="modal-concepto-factura-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Factura de venta</h4>
			</div>
			
			<form id="form-concepto-factura-component" data-toggle="validator">
				<div class="modal-body" id="modal-wrapper-concepto-factura">
					<div id="error-concepto-factura" class="alert alert-danger"></div>
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal concepto-factura -->
<div class="modal fade" id="modal-mediopago-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Cheques tercero</h4>
			</div>
			
			<form id="form-mediopago-component" data-toggle="validator">
				<div class="modal-body" id="modal-wrapper-mediopago">
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Confirm -->
<div class="modal fade" id="modal-confirm-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="content-modal"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-sm confirm-action">Confirmar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/template" id="koi-search-tercero-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de terceros</h4>
	</div>

	{!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_tercero_nit" class="col-md-1 control-label">Documento</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_tercero_nit', null, ['id' => 'koi_search_tercero_nit', 'class' => 'form-control input-sm']) !!}
				</div>

				<label for="koi_search_tercero_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-8">
					{!! Form::text('koi_search_tercero_nombre', null, ['id' => 'koi_search_tercero_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-tercero-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-tercero-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-tercero-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
				                <th>Documento</th>
				                <th>Nombre</th>
				                <th>Razon Social</th>
				                <th>Nombre1</th>
				                <th>Nombre2</th>
				                <th>Apellido1</th>
				                <th>Apellido2</th>
		                    </tr>
		                </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>
<script type="text/template" id="koi-search-contacto-component-tpl">
	{!! Form::open(['id' => 'form-koi-search-contacto-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_contacto_nombres" class="col-md-1 control-label">Nombres</label>
				<div class="col-md-5">
					{!! Form::text('koi_search_contacto_nombres', null, ['id' => 'koi_search_contacto_nombres', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
				<label for="koi_search_contacto_apellidos" class="col-md-1 control-label">Apellidos</label>
				<div class="col-md-5">
					{!! Form::text('koi_search_contacto_apellidos', null, ['id' => 'koi_search_contacto_apellidos', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-contacto-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-contacto-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-contacto-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				            	<th>Id</th>
			                	<th>Nombres</th>
			                	<th>Apellidos</th>
				                <th>Nombre</th>
				                <th>Teléfono</th>
				                <th>Municipio</th>
				                <th>Dirección</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>
<script type="text/template" id="koi-search-plancuenta-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de cuentas</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-plancuenta-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_plancuentas_cuenta" class="col-md-1 control-label">Cuenta</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_plancuentas_cuenta', null, ['id' => 'koi_search_plancuentas_cuenta', 'class' => 'form-control input-sm']) !!}
				</div>

				<label for="koi_search_plancuentas_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-8">
					{!! Form::text('koi_search_plancuentas_nombre', null, ['id' => 'koi_search_plancuentas_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-plancuenta-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-plancuenta-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-plancuenta-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Cuenta</th>
				                <th>Nivel</th>
				                <th>Nombre</th>
				                <th>Naturaleza</th>
				                <th>Tercero</th>
				            </tr>
				        </thead>
				    </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-producto-component-tpl">
	{!! Form::open(['id' => 'form-koi-search-producto-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_producto_serie" class="col-md-1 control-label">Referencia</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_producto_referencia', null, ['id' => 'koi_search_producto_referencia', 'class' => 'form-control input-sm', 'placeholder' => 'Referencia']) !!}
				</div>
				<label for="koi_search_producto_serie" class="col-md-1 control-label">Serie</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_producto_serie', null, ['id' => 'koi_search_producto_serie', 'class' => 'form-control input-sm', 'placeholder' => 'Serie']) !!}
				</div>

				<label for="koi_search_producto_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-5">
					{!! Form::text('koi_search_producto_nombre', null, ['id' => 'koi_search_producto_nombre', 'class' => 'form-control input-sm input-toupper', 'placeholder' => 'Nombre']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-producto-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-producto-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-producto-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th>Referencia</th>
				                <th>Serie</th>
			                	<th>Nombre</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-pedidoc-component-tpl">
	{!! Form::open(['id' => 'form-koi-search-pedidoc-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_pedidoc_numero" class=" col-md-offset-1 col-md-1 control-label">Numero</label>
				<div class="col-md-3 ">
					{!! Form::text('koi_search_pedidoc_numero', null, ['id' => 'koi_search_pedidoc_numero', 'class' => 'form-control input-sm', 'placeholder' => 'Número']) !!}
				</div>
				<!-- <label for="koi_search_pedidoc_cliente" class="col-md-1 control-label">Cliente</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_pedidoc_cliente', null, ['id' => 'koi_search_pedidoc_cliente', 'class' => 'form-control input-sm', 'placeholder' => 'Cliente']) !!}
				</div> -->

				<label for="koi_search_pedidoc_sucursal" class="col-md-1 control-label">Sucursal</label>
				<div class="col-md-5">
					{!! Form::text('koi_search_pedidoc_sucursal', null, ['id' => 'koi_search_pedidoc_sucursal', 'class' => 'form-control input-sm input-toupper', 'placeholder' => 'Sucursal']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-pedidoc-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-pedidoc-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-pedidoc-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th>Numero</th>
				                <th>Sucursal</th>
			                	<th>Fecha</th>
			                	<th>Vendedor</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="add-series-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-series-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		                <th>Item</th>
		                <th>Serie</th>
		            </tr>
			    </table>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="add-series-lotes-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-series-lotes-list" class="table table-hover table-bordered" cellspacing="0">
				  	<th>Lote</th>
                	<th>Fecha</th>
                	<th>Cantidad</th>
                	<th>Saldo</th>
                	<th class="text-center"> <label id="cantidad-salidau" class="label bg-green"><%- data.ajuste2_cantidad_salida %></label></th>
			    </table>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="add-itemrollo-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-itemtollo-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		            	<th>Lote</th>	
		            	<th>Rollos</th>
		                <th>Metros  (m)</th>
		                <th class="text-center">
		               		<button id="btn-itemrollo-entradau-koi-inventario" type="button" class="btn btn-success btn-sm">
								<i class="fa fa-plus"></i>
							</button>
		                </th>
		            </tr>
			    </table>
				<label id="cantidad-entradau" class="label pull-right bg-green" ><%- data.ajuste2_cantidad_entrada %> (m)</label>
			</div>
		</div>
	</div>
</script>
<script type="text/template" id="add-series-factu-tpl">
	<div id="render-series"></div>
</script>

<script type="text/template" id="choose-itemrollo-tpl">
	<div class="row">
		<div class="col-sm-12  col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-chooseitemtollo-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		                <th>Item</th>
		                <th>Lote</th>
		                <th>Fecha De Ingreso</th>
		                <th>Metros (m)</th>
		                <th>Saldo (m)</th>
		                <th></th>
		            </tr>
		            <tfoot>
		            	<tr>
		            		<th colspan ="4"></th>
		            		<th class="text-right">Total: </th>
		            		<th id="metro_residuo" class="text-right"> <label class="label bg-green"> <%- data.ajuste2_cantidad_salida %> (m)</label></th>
		            	</tr>
	            	</tfoot>
			    </table>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="product-vence-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-product-vence-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		                <th width="40%">Lote</th>
		                <th  width="20%">Unidades</th>
		                <th width="35%">Fecha De Vencimiento</th>
		                <th width="5%" class="text-center">		               		
		                	<button id="btn-vencimiento-entradau-koi-inventario" type="button" class="btn btn-success btn-sm">
								<i class="fa fa-plus"></i>
							</button>
						</th>
		            </tr>
		            <tfoot>
		            	<tr>
		            		<th colspan="3" class="text-right">Total: </th>
		            		<th id="metro_residuo" class="text-right"> <label class="label bg-green"> <%- data.ajuste2_cantidad_entrada %> </label></th>
		            	</tr>
	            	</tfoot>
			    </table>
			</div>
		</div>
	</div>
</script>
<script type="text/template" id="product-choose-vence-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-chooseproduct-vence-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		                <th width="20%">Lote</th>
		                <th width="25%">F.Ingreso</th>
		                <th width="25%">F. Vencimiento</th>
		                <th width="5%">Cantidad</th>
		                <th width="5%">Saldo</th>
		                <th width="20%"></th>
		            </tr>
		            <tfoot>
		            	<tr>
		            		<th colspan="5" class="text-right">Total: </th>
		            		<th id="metro_residuo" class="text-right"> <label class="label bg-green"> <%- data.ajuste2_cantidad_salida %> (m)</label></th>
		            	</tr>
	            	</tfoot>
			    </table>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="koi-component-select-tpl">
	<div class="modal-header">
		<h4 class="modal-title"></h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="form-group col-md-12">
			<label class="col-md-2 col-xs-12 control-label">Nombre</label>
				<div class="col-md-5">
				    <select name="component-select" id="component-select" class="form-control" required>
	                    <option value="" selected>Seleccione</option>
	                    <option value="si">Si</option>
	                    <option value="no">No</option>
	                </select>
				</div>
				<div class="col-md-5" id="component-input" hidden>
					<input type="text" class="form-control input-sm" name="component-input-text" id="component-input-text">
				</div>
			</div>
		</div>
	</div>
</script>

{{-- templates --}}
<script type="text/template" id="koi-address-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Generador de direcciones</h4>
	</div>

	{!! Form::open(['id' => 'form-address-component', 'data-toggle' => 'validator', 'role' => 'form']) !!}
	<div class="modal-body koi-component-address-modal-body">
		<div class="row">
			<div class="col-md-offset-2">
				<label for="koi_direccion" class="col-md-1 control-label">Direccion</label>
				<div class="form-group col-md-8">
					{!! Form::text('koi_direccion', null, ['id' => 'koi_direccion', 'class' => 'form-control input-sm','disabled']) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12 col-sm-12 col-xs-12">
				@foreach(config('koi.direcciones.nomenclatura') as $key => $value)
					<div class="col-md-2 col-sm-4 col-xs-6 koi-component-add address-nomenclatura">
						<a class="btn btn-default btn-block" data-key="{{$key}}">{{ $value }}</a>
					</div>
				@endforeach
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline address-digitos">
					<!-- Leters -->
					@foreach(config('koi.direcciones.alfabeto') as $key => $value)
						<li>
							<a class="btn btn-default btn-block koi-component-add" data-key="{{$key}}">{{ $value }}</a>
						</li>
					@endforeach

					<!-- Numbers -->
					@for($i=0; $i<=9; $i++)
						<li>
							<a class="btn btn-default btn-block koi-component-add">{{ $i }}</a>
						</li>
					@endfor
				</ul>
			</div>
		</div>

		<div class="row other-controls ">
			<label for="koi_direccion" class="col-md-2 col-xs-12 control-label text-right">Dirección DIAN</label>
			<div class="col-md-6">
				{!! Form::text('koi_direccion_nm', null, ['id' => 'koi_direccion_nm', 'class' => 'form-control input-sm','disabled']) !!}
			</div>
			<div class="col-md-2 koi-component-remove-last">
				<a class="btn btn-default btn-block"><i class="fa fa-backward"> Regresar</i></a>
			</div>
			<div class="col-md-2 koi-component-remove">
				<a class="btn btn-default btn-block"><i class="fa fa-trash-o"> Limpiar</i></a>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
		<button type="submit" class="btn btn-primary btn-sm btn-address-component-add-address">Continuar</button>
	</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="add-concepto-factura-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-concepto-factura-list" class="table table-hover table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th></th>
						  	<th>Fecha</th>
		                	<th>Vencimiento</th>
		                	<th>Numero</th>
		                	<th>Cuota</th>
		                	<th>Saldo</th>
		                	<th>A pagar</th>
            			</tr>
                    </thead>
                    <tbody>
                        {{-- Render content recibo2 --}}
                    </tbody>
			    </table>
			</div>
		</div>
	</div>
</script>
<script type="text/template" id="add-ch-recibo-tpl">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-cheque-list" class="table table-hover table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th width="5%"></th>
						  	<th width="40%">Banco</th>
		                	<th width="20%">N° cheque</th>
		                	<th width="15%">Valor</th>
		                	<th width="15%">Fecha</th>
            			</tr>
                    </thead>
                    <tbody>
                        {{-- Render content recibo2 --}}
                    </tbody>
			    </table>
			</div>
		</div>
	</div>
</script>