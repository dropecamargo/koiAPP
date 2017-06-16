@extends('cartera.causas.main')

@section('breadcrumb')
    <li class="active">Causas</li>
@stop

@section('module')
	<div id="causas-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="causas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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