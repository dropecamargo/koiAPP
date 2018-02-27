@extends('inventario.traslados.main')

@section('breadcrumb')
    <li class="active">Traslados</li>
@stop

@section('module')
    <div class="box box-primary" id="traslados-main">
        <div class="box-body table-responsive">
            <table id="traslados-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
