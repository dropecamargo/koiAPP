@extends('comercial.pedidos.main')

@section('breadcrumb')
    <li class="active">Pedidos comerciales</li>
@stop

@section('module')
	<div id="pedidosc-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="pedidosc-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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