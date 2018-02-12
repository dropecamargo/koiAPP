@extends('admin.tiposactividad.main')

@section('breadcrumb')
    <li class="active">Tipos de actividad</li>
@stop

@section('module')
    <div id="tiposactividad-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="tiposactividad-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Activo</th>
                            <th>Comercial</th>
                            <th>Tecnico</th>
                            <th>Cartera</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
