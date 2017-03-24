@extends('inventario.ajustes.main')

@section('breadcrumb')
    <li class="active">Ajustes</li>
@stop

@section('module')
	<div id="ajustes-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="ajustes-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Tipo Ajuste</th>
                            <th>Sucursal</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop