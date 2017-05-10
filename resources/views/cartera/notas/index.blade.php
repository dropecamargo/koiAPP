@extends('cartera.notas.main')

@section('breadcrumb')
    <li class="active">Notas</li>
@stop

@section('module')
	<div id="notas-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="notas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Sucursal</th>
                            <th>Tercero</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop