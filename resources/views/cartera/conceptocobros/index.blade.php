@extends('cartera.conceptocobros.main')

@section('breadcrumb')
    <li class="active">Concepto Cobro</li>
@stop

@section('module')
	<div id="conceptocobros-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="conceptocobros-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
