@extends('inventario.unidadesnegocio.main')

@section('breadcrumb')
    <li class="active">Unidades de negocio</li>
@stop

@section('module')
    <div id="unidadesnegocio-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="unidadesnegocio-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
