@extends('contabilidad.plancuentas.main')

@section('breadcrumb')
	<li class="active">Plan de cuentas</li>
@stop

@section('module')
	<div id="plancuentas-main">
		<div class="box box-primary">
			<div class="box-body">
				{!! Form::open(['id' => 'form-koi-search-plancuenta-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
					<div class="form-group">
						<label for="plancuentas_cuenta" class="col-sm-1 control-label">Cuenta</label>
						<div class="col-sm-2">
							{!! Form::text('plancuentas_cuenta', session('search_plancuentas_cuenta'), ['id' => 'plancuentas_cuenta', 'class' => 'form-control input-sm']) !!}
						</div>

						<label for="plancuentas_nombre" class="col-sm-1 control-label">Nombre</label>
						<div class="col-sm-8">
							{!! Form::text('plancuentas_nombre', session('search_plancuentas_nombre'), ['id' => 'plancuentas_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-2 col-xs-4">
							<button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
						</div>
						<div class="col-sm-2 col-xs-4">
							<button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
						</div>
						<div class="col-sm-2 col-xs-4">
							<a href="{{ route('plancuentas.create') }}" class="btn btn-default btn-block btn-sm">
								<i class="fa fa-plus"></i> Nueva
							</a>
						</div>
					</div>
				{!! Form::close() !!}

				<div class="table-responsive">
					<table id="plancuentas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Cuenta</th>
				                <th>Nivel</th>
				                <th>Nombre</th>
				                <th>Naturaleza</th>
				                <th>Tercero</th>
				                <th>Cuenta NIF</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
	</div>
@stop
