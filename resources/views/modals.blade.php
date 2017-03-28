<!-- Modal add resource -->
<div class="modal fade" id="modal-add-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-create-resource-component">
			<div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-create-resource-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body box box-success">
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
<!-- Modal inventario -->
<div class="modal fade" id="modal-inventario-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-create-inventario-entrada-component-source', 'data-toggle' => 'validator']) !!}
				<div class="modal-body" id="modal-wrapper-inventario">
					<div id="error-inventario" class="alert alert-danger"></div>
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
<!-- Modal add tcontacto -->
<div class="modal fade" id="modal-tcontacto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-tcontacto-component">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="inner-title-modal">Contactos</h4>
			</div>
			{!! Form::open(['id' => 'form-tcontacto-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body box box-success">
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
			<div class="content-modal"></div>
		</div>
	</div>
</div>
<!-- Modal Confirm -->
<div class="modal fade" id="modal-confirm-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Buscador de terceros</h4>
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

<script type="text/template" id="koi-search-plancuenta-component-tpl">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Buscador de cuentas</h4>
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
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Buscador de productos</h4>
	</div>
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
<script type="text/template" id="add-series-tpl">
	<div class="row">
		<div class="col-sm-6 col-md-offset-3 col-xs-12">
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
		<div class="col-sm-8 col-md-offset-2 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-series-lotes-list" class="table table-hover table-bordered" cellspacing="0">
				  	<th>Lote</th>
                	<th>Fecha</th>
                	<th>Saldo</th>
                	<th></th>
			    </table>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="add-itemrollo-tpl">
	<div class="row">
		<div class="col-sm-4 col-md-offset-4 col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-itemtollo-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		                <th>Item</th>
		                <th>Metros (m)</th>
		            </tr>
			    </table>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="choose-itemrollo-tpl">
	<div class="row">
		<div class="col-sm-12  col-xs-12">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-chooseitemtollo-list" class="table table-hover table-bordered" cellspacing="0">
		            <tr>
		                <th>Item</th>
		                <th>Metros (m)</th>
		                <th>Saldo (m)</th>
		                <th>Lote</th>
		                <th>Fecha De Ingreso</th>
		                <th></th>
		            </tr>
			    </table>
			</div>
		</div>
	</div>
</script>

