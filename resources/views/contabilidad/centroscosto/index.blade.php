@extends('contabilidad.centroscosto.main')

@section('breadcrumb')
	<li class="active">Centros de costo</li>
@stop

@section('module')
	<div id="centroscosto-main">
		<div class="box box-primary">
			<div class="box-body table-responsive">
				<table id="centroscosto-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>#</th>
							<th>Código</th>
			                <th>Centro</th>
			                <th>Nombre</th>
			                <th>Subnivel</th>
			                <th>Activo</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
	</div>
@stop
