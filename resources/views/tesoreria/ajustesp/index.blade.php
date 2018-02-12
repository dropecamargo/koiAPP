@extends('tesoreria.ajustesp.main')

@section('breadcrumb')
    <li class="active">Ajuste proveedor</li>
@stop

@section('module')
	<div id="ajustesp-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="ajustesp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tercero</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
