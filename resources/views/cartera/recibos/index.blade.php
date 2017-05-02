@extends('cartera.recibos.main')

@section('breadcrumb')
    <li class="active">Recibo</li>
@stop

@section('module')
	<div id="recibos1-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="recibos1-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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