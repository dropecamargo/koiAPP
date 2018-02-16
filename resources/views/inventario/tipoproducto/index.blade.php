@extends('inventario.tipoproducto.main')

@section('breadcrumb')
    <li class="active">Modelos</li>
@stop

@section('module')
    <div id="tiposproducto-main">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table id="tiposproducto-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
