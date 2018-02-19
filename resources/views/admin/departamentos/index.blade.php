@extends('admin.departamentos.main')

@section('breadcrumb')
	<li class="active">Departamentos</li>
@stop

@section('module')
	<div class="box box-primary" id="departamentos-main">
		<div class="box-body table-responsive">
			<table id="departamentos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		                <th>Código</th>
		                <th>Nombre</th>
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
@stop
