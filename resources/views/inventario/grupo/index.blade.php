@extends('inventario.grupo.main')

@section('breadcrumb')
    <li class="active">Grupos</li>
@stop

@section('module')
    <div class="box box-primary" id="grupos-main">
        <div class="box-body table-responsive">
            <table id="grupos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
