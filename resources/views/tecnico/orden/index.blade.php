@extends('tecnico.orden.main')

@section('module')
    <section class="content-header">
        <h1>
            Ordenes <small>Administración de ordenes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Ordenes</li>
        </ol>
    </section>

    <section class="content">
    	<div id="orden-main">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                        <div class="form-group">
                            <label for="searchorden_orden_id" class="col-md-1 control-label">Código</label>
                            <div class="col-md-2">
                                <input id="searchorden_orden_id" placeholder="Código" class="form-control input-sm" name="searchorden_orden_id" type="text" maxlength="15" value="{{ session('searchorden_orden_id') }}">
                            </div>

                            <label for="searchorden_orden_estado" class="col-md-1 control-label">Estado</label>
                            <div class="col-md-2">
                                <select name="searchorden_orden_estado" id="searchorden_orden_estado" class="form-control">
                                    <option value="" selected>Todas</option>
                                    <option value="A" {{ session('searchorden_orden_estado') == 'A' ? 'selected': '' }}>Abiertas</option>
                                    <option value="C" {{ session('searchorden_orden_estado') == 'C' ? 'selected': '' }}>Cerradas</option>
                                </select>
                            </div>

                            <label for="searchorden_tercero" class="col-md-1 control-label">Tercero</label>
                            <div class="col-md-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchorden_tercero">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="searchorden_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchorden_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-ordenp" data-name="searchorden_tercero_nombre" value="{{ session('searchorden_tercero') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input id="searchorden_tercero_nombre" name="searchorden_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchorden_tercero_nombre') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-sm-2 col-xs-4">
                                <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <a href="{{ route('ordenes.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-building-o"></i> Nueva orden
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="box-body table-responsive">
                        <table id="orden-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Sucursal</th>
                                    <th>F. Servicio</th>
                                    <th>H. Servicio</th>
                                    <th>Tercero</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
