@extends('tecnico.sitios.main')

@section('breadcrumb')
    <li class="active">Sitios</li>
@stop

@section('module')
	<div id="sitios-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="sitios-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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