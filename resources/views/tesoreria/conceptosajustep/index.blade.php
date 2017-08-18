@extends('tesoreria.conceptosajustep.main')

@section('breadcrumb')
    <li class="active">Conceptos ajuste de proveedor</li>
@stop

@section('module')
	<div id="conceptoajustep-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="conceptoajustep-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Plan de cuenta</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop