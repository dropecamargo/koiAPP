@extends('comercial.gestionescomercial.main')

@section('breadcrumb')
    <li class="active">Gestión comercial</li>
@stop

@section('module')
	<div id="gestionescomercial-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="gestionescomercial-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Concepto</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
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
