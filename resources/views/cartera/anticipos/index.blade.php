@extends('cartera.anticipos.main')

@section('breadcrumb')
    <li class="active">Anticipos</li>
@stop

@section('module')
	<div id="anticipos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="anticipos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Identificación</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop