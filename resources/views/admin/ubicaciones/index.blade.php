@extends('admin.ubicaciones.main')

@section('breadcrumb')
    <li class="active">Ubicaciones</li>
@stop

@section('module')
    <div id="ubicaciones-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="ubicaciones-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Sucursal</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop