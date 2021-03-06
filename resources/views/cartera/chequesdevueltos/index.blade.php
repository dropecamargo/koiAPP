@extends('cartera.chequesdevueltos.main')

@section('breadcrumb')
    <li class="active">Cheques devueltos</li>
@stop

@section('module')
	<div id="chequesdevueltos-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="chequesdevueltos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Sucursal</th>
                            <th>Banco</th>
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
