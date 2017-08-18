@extends('tesoreria.tipopago.main')

@section('breadcrumb')
    <li class="active">Tipo de pago</li>
@stop

@section('module')
	<div id="tipopagos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="tipopagos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop