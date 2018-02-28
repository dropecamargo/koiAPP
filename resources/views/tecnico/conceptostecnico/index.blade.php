@extends('tecnico.conceptostecnico.main')

@section('breadcrumb')
    <li class="active">Concepto técnico</li>
@stop

@section('module')
    <div class="box box-primary" id="conceptostecnico-main">
        <div class="box-body table-responsive">
            <table id="conceptostecnico-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
