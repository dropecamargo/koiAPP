@extends('admin.sucursales.main')

@section('breadcrumb')
    <li class="active">Sucursales</li>
@stop

@section('module')
    <div class="box box-primary" id="sucursales-main">
        <div class="box-body table-responsive">
            <table id="sucursales-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Direccion</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
