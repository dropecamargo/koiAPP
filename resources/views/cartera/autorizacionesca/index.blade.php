@extends('cartera.autorizacionesca.main')

@section('breadcrumb')
    <li class="active">Autorizaciones</li>
@stop

@section('module')
	<div id="autorizacionesca-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="autorizacionesca-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tercero</th>
                            <th>F.Vencimiento</th>
                            <th>Plazo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
