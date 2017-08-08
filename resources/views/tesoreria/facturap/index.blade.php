@extends('tesoreria.facturap.main')

@section('module')
    <section class="content-header">
        <h1>
            Facturas proveedor <small>Administración de facturas proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Facturas proveedor</li>
        </ol>
    </section>
    <section class="content">
        <div id="facturasp-main">
            <div class="box box-success">
                <div class="box-body">
                    {!! Form::open(['id' => 'form-koi-search-facturap-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                        <div class="form-group">
                            <label for="searchfacturap_tercero" class="col-sm-1 control-label">Tercero</label>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchfacturap_tercero">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="searchfacturap_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchfacturap_tercero" type="text" maxlength="15" data-name="searchfacturap_tercero_nombre" value="{{ session('searchfacturap_tercero') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input id="searchfacturap_tercero_nombre" name="searchfacturap_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchfacturap_tercero_nombre') }}">
                            </div>

                            <label for="searchfacturap_factura" class="col-sm-1 control-label">Factura</label>
                            <div class="col-sm-2">
                                <input id="searchfacturap_factura" placeholder="Nombre factura" class="form-control input-sm" name="searchfacturap_factura" type="text" maxlength="15" value="{{ session('searchfacturap_factura') }}">
                            </div>

                            <label for="searchfacturap_fecha" class="col-sm-1 control-label">Fecha</label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="searchfacturap_fecha" placeholder="Fecha" class="form-control input-sm datepicker" name="searchfacturap_fecha" type="text" value="{{ session('searchfacturap_fecha') }}">
                                </div>
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
                                <a href="{{ route('facturasp.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-plus"></i> Nueva factura 
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>

                <div class="box-body table-responsive">
                    <table id="facturasp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th >Código</th>
                                <th >Cliente</th>
                                <th >Regional</th>
                                <th >Factura</th>
                                <th >Fecha</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop