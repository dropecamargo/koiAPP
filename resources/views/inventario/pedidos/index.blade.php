@extends('inventario.pedidos.main')

@section('breadcrumb')	
	<li class="active">Pedidos</li>
@stop

@section('module')
	<div id="pedido-main">
		<div class="box box-success">
			<div class="box-body table-responsive">
				<table id="pedido-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Número</th>
			                <th>Sucursal</th>
			                <th>Tercero</th>
			                <th>Fecha</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
	</div>
@stop
