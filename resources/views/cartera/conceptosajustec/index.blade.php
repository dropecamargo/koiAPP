@extends('cartera.conceptosajustec.main')

@section('breadcrumb')
    <li class="active">Conceptos ajustes de cartera</li>
@stop

@section('module')
	<div id="conceptoajustec-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="conceptoajustec-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
