@extends('inventario.ajustes.main')

@section('breadcrumb')
    <li class="active">Ajustes</li>
@stop

@section('module')
	<div id="ajustes-main">
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-ajuste-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="form-group">
                        <label for="searchajuste_ajuste_tipo" class="col-md-1 control-label">Tipo</label>
                        <div class="col-md-2">
                            <select name="searchajuste_ajuste_tipo" id="searchajuste_ajuste_tipo" class="form-control select2-default-clear">
                                @foreach( App\Models\Inventario\TipoAjuste::getTiposAjustes() as $key => $value)
                                    <option  value="{{ $key }}" {{ session('searchajuste_ajuste_tipo') == $key ? 'selected': '' }} >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="searchajuste_ajuste_sucursal" class="col-md-1 control-label">Sucursal</label>
                        <div class="col-md-4">
                            <select id="searchajuste_ajuste_sucursal"  class="form-control select2-default-clear" name="searchajuste_ajuste_sucursal">
                                @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                    <option  value="{{ $key }}" {{ session('searchajuste_ajuste_sucursal') == $key ? 'selected': '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="searchajuste_ajuste_fecha" class="col-md-1 control-label">Fecha</label>
                        <div class="col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="searchajuste_ajuste_fecha" type="text" name="searchajuste_ajuste_fecha" class="form-control datepicker" value = "{{ session('searchajuste_ajuste_fecha') }}" placeholder="Fecha" >
                            </div>
                        </div>
                        <div class="col-md-1">
                            <a href="#" class="btn btn-default btn-sm btn-import-modal"><i class="fa fa-upload"></i> Importar</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-2 col-xs-4">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <a href="{{ route('ajustes.create') }}" class="btn btn-default btn-block btn-sm">
                                <i class="fa fa-plus"></i> Nuevo ajuste
                            </a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="box-body table-responsive">
                <table id="ajustes-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tipo Ajuste</th>
                            <th>Sucursal</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
