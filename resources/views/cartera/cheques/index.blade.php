@extends('cartera.cheques.main')

@section('breadcrumb')
    <li class="active">Cheques</li>
@stop

@section('module')
	<div id="cheques-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="cheques-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Banco</th>
                            <th>Sucursal</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
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
@stop