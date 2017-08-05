@extends('tesoreria.tipogasto.main')

@section('breadcrumb')
    <li class="active">Tipo de proveedor</li>
@stop

@section('module')
	<div id="tipogastos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="tipogastos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop