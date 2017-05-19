@extends('cartera.devoluciones.main')

@section('breadcrumb')
    <li class="active">Devoluciones</li>
@stop

@section('module')
	<div id="devoluciones-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="devoluciones-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Sucursal</th>
                            <th>Cliente</th>
                            <th>Razon Social</th>
                            <th>Nombre1</th>
                            <th>Nombre2</th>
                            <th>Apellido1</th>
                            <th>Apellido2</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop