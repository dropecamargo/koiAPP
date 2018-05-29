@extends('tesoreria.conceptoscajamenor.main')

@section('breadcrumb')
    <li class="active">Conceptos caja menor</li>
@stop

@section('module')
    <div class="box box-primary" id="conceptoscajamenor-main">
        <div class="box-body table-responsive">
            <table id="conceptoscajamenor-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Activo</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
