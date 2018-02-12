@extends('cartera.anticipos.main')

@section('breadcrumb')
    <li class="active">Anticipos</li>
@stop

@section('module')
	<div id="anticipos-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="anticipos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Sucursal</th>
                            <th>Identificación</th>
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
