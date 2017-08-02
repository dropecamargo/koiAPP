@extends('tesoreria.retefuente.main')

@section('breadcrumb')
    <li class="active">Retención en la fuente</li>
@stop

@section('module')
	<div id="retefuentes-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="retefuentes-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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