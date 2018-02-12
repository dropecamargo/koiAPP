@extends('inventario.tipostraslados.main')

@section('breadcrumb')
    <li class="active">Tipos de traslados</li>
@stop

@section('module')
    <div id="tipostraslados-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="tipostraslados-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Sigla</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
