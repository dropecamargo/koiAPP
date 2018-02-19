@extends('admin.ubicaciones.main')

@section('breadcrumb')
    <li class="active">Ubicaciones</li>
@stop

@section('module')
    <div class="box box-primary" id="ubicaciones-main">
        <div class="box-body table-responsive">
            <table id="ubicaciones-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Sucursal</th>
                        <th>Activo</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
