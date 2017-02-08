<!-- Modal add resource -->
<div class="modal fade" id="modal-add-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-create-resource-component">
			<div class="modal-header">
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

<!-- Modal search -->
<div class="modal fade" id="modal-search-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

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