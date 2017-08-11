@extends('contabilidad.activofijos.main')

@section('breadcrumb')
    <li class="active">Activo fijo</li>
@stop

@section('module')
	<div id="activofijos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="activofijos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Placa</th>
                            <th>Serie</th>
                            <th>Responsable</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop