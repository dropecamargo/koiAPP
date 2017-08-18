@extends('tesoreria.egreso.main')

@section('breadcrumb')
    <li class="active">Egreso</li>
@stop

@section('module')
	<div id="egresos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="egresos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tercero</th>
                            <th>Regional</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop