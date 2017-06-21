@extends('tecnico.conceptostecnico.main')

@section('breadcrumb')
    <li class="active">Concepto tecnico</li>
@stop

@section('module')
	<div id="conceptostecnico-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="conceptostecnico-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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