@extends('cobro.deudores.main')

@section('breadcrumb')
    <li class="active">Deudores</li>
@stop

@section('module')
    <div class="box box-primary" id="deudores-main">
        <div class="box-body table-responsive">
            <table id="deudores-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="10%">Código</th>
                        <th width="40%">Tercero</th>
                        <th width="10%">Nit(deudor)</th>
                        <th width="40%">Nombres(deudor)</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
