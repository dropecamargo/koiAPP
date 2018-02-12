@extends('comercial.conceptoscomercial.main')

@section('breadcrumb')
    <li class="active">Concepto Comercial</li>
@stop

@section('module')
	<div id="conceptoscomercial-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="conceptoscomercial-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
