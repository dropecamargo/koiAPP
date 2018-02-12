@extends('cartera.cuentabancos.main')

@section('breadcrumb')
    <li class="active">Cuentas de banco</li>
@stop

@section('module')
	<div id="cuentabancos-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="cuentabancos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Banco</th>
                            <th>Plan de cuenta</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
