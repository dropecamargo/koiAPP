@extends('cartera.conceptonotas.main')

@section('breadcrumb')
    <li class="active">Conceptos de nota</li>
@stop

@section('module')
	<div id="conceptonota-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="conceptonota-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th width="50%">Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
