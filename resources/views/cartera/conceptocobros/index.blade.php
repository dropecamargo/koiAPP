@extends('cartera.conceptocobros.main')

@section('breadcrumb')
    <li class="active">Concepto de cobro</li>
@stop

@section('module')
    <div class="box box-primary" id="conceptocobros-main">
        <div class="box-body table-responsive">
            <table id="conceptocobros-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
@stop
