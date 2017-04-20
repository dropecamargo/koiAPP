@extends('inventario.tipostraslados.main')

@section('breadcrumb')
    <li class="active">Tipos Traslados</li>
@stop

@section('module')
    <div id="tipostraslados-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="tipostraslados-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
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