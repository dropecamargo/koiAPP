@extends('contabilidad.tipoactivo.main')

@section('breadcrumb')
    <li class="active">Tipo activo</li>
@stop

@section('module')
	<div id="tipoactivos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="tipoactivos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop