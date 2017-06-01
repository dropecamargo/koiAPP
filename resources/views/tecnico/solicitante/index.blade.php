@extends('tecnico.solicitante.main')

@section('breadcrumb')
    <li class="active">Solicitantes</li>
@stop

@section('module')
	<div id="solicitantes-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="solicitantes-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop