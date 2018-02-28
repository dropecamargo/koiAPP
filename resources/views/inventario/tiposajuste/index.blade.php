@extends('inventario.tiposajuste.main')

@section('breadcrumb')
    <li class="active">Tipos de ajuste</li>
@stop

@section('module')
    <div class="box box-primary" id="tiposajuste-main">
        <div class="box-body table-responsive">
            <table id="tiposajuste-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Activo</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
