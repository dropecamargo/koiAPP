@extends('cartera.gestioncobros.main')

@section('breadcrumb')
    <li class="active">Gestión de cobros</li>
@stop

@section('module')
	<div id="gestioncobros-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="gestioncobros-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Concepto</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Fecha proxima</th>
                            <th>Nit</th>
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
