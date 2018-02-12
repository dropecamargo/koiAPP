@extends('inventario.unidades.main')

@section('breadcrumb')
    <li class="active">Unidades de medida</li>
@stop

@section('module')
    <div id="unidades-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="unidades-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
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
