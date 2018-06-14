@extends('cobro.gestiondeudores.main')

@section('breadcrumb')
    <li class="active">Gestión de cartera</li>
@stop

@section('module')
	<div id="gestiondeudores-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="gestiondeudores-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Concepto</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Fecha proxima</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
