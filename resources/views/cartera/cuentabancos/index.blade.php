@extends('cartera.cuentabancos.main')

@section('breadcrumb')
    <li class="active">Cuentas de banco</li>
@stop

@section('module')
    <div class="box box-primary" id="cuentabancos-main">
        <div class="box-body table-responsive">
            <table id="cuentabancos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th width="40%">Nombre</th>
                        <th width="40%">Banco</th>
                        <th>Activo</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
