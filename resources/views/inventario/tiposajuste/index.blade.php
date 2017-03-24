@extends('inventario.tiposajuste.main')

@section('breadcrumb')
    <li class="active">Tipos Ajustes</li>
@stop

@section('module')
    <div id="tiposajuste-main">
        <div class="box box-success">
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
    </div>
@stop