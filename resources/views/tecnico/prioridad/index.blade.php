@extends('tecnico.prioridad.main')

@section('breadcrumb')
    <li class="active">Prioridades</li>
@stop

@section('module')
	<div id="prioridades-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="prioridades-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
