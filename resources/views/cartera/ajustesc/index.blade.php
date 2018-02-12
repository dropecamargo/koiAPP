@extends('cartera.ajustesc.main')

@section('breadcrumb')
    <li class="active">Ajuste cartera</li>
@stop

@section('module')
	<div id="ajustesc-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="ajustesc-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
