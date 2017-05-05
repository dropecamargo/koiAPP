@extends('cartera.facturas.main')

@section('breadcrumb')
    <li class="active">Facturas</li>
@stop

@section('module')
	<div id="facturas-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="facturas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tercero</th>
                            <th>Sucursal</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop