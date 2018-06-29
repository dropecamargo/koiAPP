@extends('layout.layout')

@section('title') Facturas proveedor @stop

@section('content')
    @yield ('module')
    <script type="text/template" id="add-facturap-tpl">
        <section class="content-header">
            <h1>
                Facturas proveedor <small>Administración de facturas proveedor</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
                <li><a href="{{ route('facturasp.index')}}">Factura proveedor</a></li>

                <% if (!_.isUndefined(edit) && !_.isNull(edit) && edit ){ %>
                    <li><a href="<%- window.Misc.urlFull( Route.route('facturasp.show', { facturasp: id}) ) %>"><%- id %></a></li>
                    <li class="active">Editar</li>
                 <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>
        <section class="content">
            <div id="spinner-main" class="box box-solid">
                <div class="nav-tabs-custom tab-warning tab-whithout-box-shadow">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_facturap" data-toggle="tab">Factura</a></li>
                        <li><a href="#tab_impuesto" data-toggle="tab">Impuesto/Retención</a></li>
                        <li><a href="#tab_af" data-toggle="tab">Activos fijos</a></li>
                        <li><a href="#tab_inventario" data-toggle="tab">Inventario</a></li>
                        <li><a href="#tab_centrocosto" data-toggle="tab">Centro costo</a></li>
                        <li><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Tab factura proveedor -->
                        <div id="tab_facturap" class="tab-pane active">
                            <form method="POST" accept-charset="UTF-8" id="form-facturap" data-toggle="validator">
                                <div class="row">
                                    <label for = "facturap1_regional" class="control-label col-md-1">Regional</label>
                                    <div class="form-group col-md-3">
                                        <select name="facturap1_regional" id="facturap1_regional" class="form-control select2-default-clear change-regional-consecutive-koi-component" data-field="facturap1_numero" data-document ="facturap" data-wrapper="spinner-main">
                                        @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                                            <option  value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <label for="facturap1_numero" class="col-md-1 control-label">Número</label>
                                    <div class="form-group col-md-1">
                                        <input id="facturap1_numero" name="facturap1_numero" class="form-control input-sm" type="number" min="1" value="<%- facturap1_numero %>" required readonly>
                                    </div>
                                    <label for="facturap1_fecha" class="col-md-1 control-label">Fecha</label>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" id="facturap1_fecha" name="facturap1_fecha" class="form-control input-sm datepicker" value="<%- facturap1_fecha %>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="facturap1_tercero" class="col-md-1 control-label">Cliente</label>
                                    <div class="form-group col-md-3">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="facturap1_tercero">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </span>
                                            <input id="facturap1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="facturap1_tercero" type="text" maxlength="15" data-wrapper="facturap1-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="facturap1_factura" class="control-label col-md-1">Factura</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" id="facturap1_factura" name="facturap1_factura" class="form-control input-sm input-toupper" maxlength="20" value="<%- facturap1_factura %>" placeholder="Factura" required>
                                    </div>
                                    <label for="facturap1_vencimiento" class="control-label col-md-1">Vencimiento</label>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" id="facturap1_vencimiento" name="facturap1_vencimiento" class="form-control input-sm datepicker" value="<%- facturap1_vencimiento %>" required>
                                        </div>
                                    </div>
                                    <label for="facturap1_primerpago" class="control-label col-md-1">Primer pago</label>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" id="facturap1_primerpago" name="facturap1_primerpago" class="form-control input-sm datepicker" value="<%- facturap1_primerpago %>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="facturap1_cuotas" class="control-label col-md-1">Cuota</label>
                                    <div class="form-group col-md-1">
                                        <input type="number" id="facturap1_cuotas" name="facturap1_cuotas" class="form-control input-sm" value="<%- facturap1_cuotas %>" required>
                                    </div>
                                    <label for="facturap1_subtotal" class="control-label col-md-1">Subtotal</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" id="facturap1_subtotal" name="facturap1_subtotal" class="form-control input-sm" value="<%- facturap1_subtotal %>" data-currency required>
                                    </div>
                                    <label for="facturap1_descuento" class="control-label col-md-1">Descuento</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" id="facturap1_descuento" name="facturap1_descuento" class="form-control input-sm" value="<%- facturap1_descuento %>" data-currency required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="facturap1_tipoproveedor" class="control-label col-md-1">Tipo proveedor</label>
                                    <div class="form-group col-md-4">
                                        <select id="facturap1_tipoproveedor" name="facturap1_tipoproveedor" class="form-control select2-default-clear">
                                            @foreach( App\Models\Tesoreria\TipoProveedor::getTiposProveedores() as $key => $value)
                                            <option  value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="facturap1_tipogasto" class="control-label col-md-1">Tipo gasto</label>
                                    <div class="form-group col-md-4">
                                        <select id="facturap1_tipogasto" name="facturap1_tipogasto" class="form-control select2-default-clear">
                                            @foreach( App\Models\Tesoreria\TipoGasto::getTiposGastos() as $key => $value)
                                            <option  value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="facturap1_observaciones" class="col-md-1 control-label">Observaciones</label>
                                    <div class="form-group col-md-10">
                                        <textarea id="facturap1_observaciones" name="facturap1_observaciones" class="form-control" rows="2" placeholder="Observaciones factura proveedor"><%- facturap1_observaciones %></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Tab impuesto -->
                        <div id="tab_impuesto" class="tab-pane">
                            <form method="POST" accept-charset="UTF-8" id="form-facturap2-impuesto" data-toggle="validator">
                                <div class="row">
                                    <label for="facturap2_impuesto" class="control-label col-md-1">Impuesto</label>
                                    <div class="form-group col-md-4">
                                        <select id="facturap2_impuesto" name="facturap2_impuesto" class="form-control select2-default-clear">
                                            @foreach( App\Models\Inventario\Impuesto::getImpuestos() as $key => $value)
                                                <option  value="{{ $key }}" >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <input type="text" id="facturap2_impuesto_porcentaje" name="facturap2_impuesto_porcentaje" class="form-control input-sm" disabled>
                                    </div>
                                    <label for="facturap2_base_impuesto" class="control-label col-md-1">Valor</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" id="facturap2_base_impuesto" name="facturap2_base_impuesto" class="form-control input-sm" data-currency readonly required>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <button type="sumbit" class="btn btn-success btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form method="POST" accept-charset="UTF-8" id="form-facturap2-retefuente" data-toggle="validator">
                                <div class="row">
                                    <label for="facturap2_retefuente" class="control-label col-md-1">Retefuente</label>
                                    <div class="form-group col-md-4">
                                        <select id="facturap2_retefuente" name="facturap2_retefuente" class="form-control select2-default-clear">
                                            @foreach( App\Models\Tesoreria\ReteFuente::getReteFuentes() as $key => $value)
                                                <option  value="{{ $key }}" >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <input type="text" id="facturap2_retefuente_porcentaje" name="facturap2_retefuente_porcentaje" class="form-control input-sm" disabled>
                                    </div>
                                    <label for="facturap2_base_retefuente" class="control-label col-md-1">Valor</label>
                                    <div class="col-md-2">
                                        <input type="text" id="facturap2_base_retefuente" name="facturap2_base_retefuente" class="form-control input-sm" data-currency readonly required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="submit" class="btn btn-success btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive no-padding">
                                <table id="browse-detalle-facturap2-list" class="table table-hover table-bordered table-condensed" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%"></th>
                                            <th width="30%">Nombre</th>
                                            <th width="15%">%</th>
                                            <th width="15%">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content detalle facturap2 --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab activos & efectivos -->
                        <div id="tab_af"  class="tab-pane">
                            <form  method="POST" accept-charset="UTF-8" id="form-activo-fijo" data-toggle="validator">
                                <div class="row">
                                    <label for="activofijo_placa" class="control-label col-md-1">Placa</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" name="activofijo_placa" id="activofijo_placa" class="form-control input-sm input-toupper" placeholder="Placa" maxlength="10" required>
                                    </div>

                                    <label for="activofijo_serie" class="control-label col-md-1">Serie</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" name="activofijo_serie" id="activofijo_serie" class="form-control input-sm input-toupper" placeholder="Serie" maxlength="20" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="activofijo_responsable" class="col-md-1 control-label">Responsable</label>
                                    <div class="form-group col-md-3">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="activofijo_responsable">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </span>
                                            <input id="activofijo_responsable" placeholder="Responsable" class="form-control tercero-koi-component" name="activofijo_responsable" type="text" maxlength="15" data-wrapper="facturap1-create" data-name="activofijo_tercero_nombre"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <input id="activofijo_tercero_nombre" name="activofijo_tercero_nombre" placeholder="Nombre resposanble" class="form-control input-sm" type="text" maxlength="15" readonly required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="activofijo_tipoactivo" class="control-label col-md-1">Tipo</label>
                                    <div class="form-group col-md-3">
                                        <select id="activofijo_tipoactivo" name="activofijo_tipoactivo" class="form-control select2-default-clear">
                                            @foreach( App\Models\Contabilidad\TipoActivo::getTiposActivos() as $key => $value)
                                                <option  value="{{ $key }}" >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="activofijo_costo" class="control-label col-md-1">Costo</label>
                                    <div class="form-group col-md-2">
                                        <input type="text" id="activofijo_costo" name="activofijo_costo" class="form-control input-sm" data-currency required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="activofijo_compra" class="control-label col-md-1">F. compra</label>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" id="activofijo_compra" name="activofijo_compra" class="form-control input-sm datepicker" value="<%- moment().format('YYYY-MM-DD') %>" required>
                                        </div>
                                    </div>
                                    <label for="activofijo_activacion" class="control-label col-md-1">F. activación</label>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" id="activofijo_activacion" name="activofijo_activacion" class="form-control input-sm datepicker" value="<%- moment().format('YYYY-MM-DD') %>" required>
                                        </div>
                                    </div>
                                    <label for="activofijo_vida_util" class="control-label col-md-1">Vida útil</label>
                                    <div class="form-group col-md-1">
                                        <input type="number" name="activofijo_vida_util" id="activofijo_vida_util" value="1" min="1" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="activofijo_descripcion" class="control-label col-md-1">Descripción</label>
                                    <div class="form-group col-md-9">
                                        <textarea id="activofijo_descripcion" name="activofijo_descripcion" class="form-control" rows="2" placeholder="Descripción del activo"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-5 col-xs-6">
                                        <button type="submit" class="btn btn-success btn-sm btn-block">{{ trans('app.add') }}</button>
                                    </div>
                                </div><br>
                            </form>
                            <div class="table-responsive no-padding">
                                <table id="browse-activo-fijo-list" class="table table-hover table-bordered table-condensed" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%"></th>
                                            <th width="10%">Placa</th>
                                            <th width="15%">Serie</th>
                                            <th width="40%">Responsable</th>
                                            <th width="20%">Tipo</th>
                                            <th width="10%">Costo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content activo fijo --}}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- Tab inventario -->
                        <div id="tab_inventario" class="tab-pane">
                            <form method="POST" accept-charset="UTF-8" id="form-entrada">
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label for="" class="control-label">Sucursal</label>
                                        <select name="entrada1_sucursal" id="entrada1_sucursal" class="form-control select2-default-clear change-sucursal-consecutive-koi-component" data-field="entrada1_numero" data-document ="entrada" data-wrapper="spinner-main">
                                            @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                                <option  value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="entrada1_numero" class="control-label">Número</label>
                                        <input type="text" id="entrada1_numero" name="entrada1_numero" class="form-control input-sm" required readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="entrada1_fecha" class="control-label">Fecha</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" id="entrada1_fecha" name="entrada1_fecha" class="form-control input-sm datepicker" value="<%- moment().format('YYYY-MM-DD') %>" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label form="entrada1_lote" class="control-label">Lote</label>
                                        <input type="text" id="entrada1_lote" name="entrada1_lote" class="form-control input-sm input-toupper" maxlength="50" placeholder="Lote" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="entrada1_observaciones" class="control-label">Observaciones</label>
                                        <textarea id="entrada1_observaciones" name="entrada1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                                    </div>
                                </div>
                            </form>
                            <form  method="POST" accept-charset="UTF-8" id="form-entrada-detalle" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="producto_serie" class="control-label">Producto</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_serie">
                                                    <i class="fa fa-barcode"></i>
                                                </button>
                                            </span>
                                            <input id="producto_serie" placeholder="Serie" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="facturap-create" data-office= "ajuste1_sucursal" data-name="producto_nombre" data-ref="true" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5"><br>
                                        <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="entrada2_cantidad" class="control-label">Cantidad</label>
                                        <input id="entrada2_cantidad" name="entrada2_cantidad" min="1" class="form-control input-sm " type="number" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="entrada2_costo" class="control-label">Costo</label>
                                        <input id="entrada2_costo" name="entrada2_costo" class="form-control input-sm" type="text" data-currency required>
                                    </div>
                                    <div class="form-group col-md-1"><br>
                                        <button type="submit" class="btn btn-success btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive no-padding">
                                <table id="browse-entrada2-treasury-list" class="table table-hover table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%"></th>
                                            <th width="25%">Referencia</th>
                                            <th width="50%">Nombre</th>
                                            <th width="10%">Cantidad</th>
                                            <th width="10%">Costo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content detalle entrada2 --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Tab centro costo -->
                        <div id="tab_centrocosto" class="tab-pane">
                            <form  method="POST" accept-charset="UTF-8" id="facturap4-centrocosto" data-toggle="validator">
                                <div class="row">

                                    <div class="form-group col-md-5">
                                        <label for="facturap4_centrocosto" class="control-label text-right">Unidad de decisión</label>
                                        <select name="facturap4_centrocosto" id="facturap4_centrocosto" class="form-control select2-default-clear" data-placeholder="Seleccione centro de costo">
                                            @foreach( App\Models\Contabilidad\CentroCosto::getCentrosCosto() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="facturap4_valor" class="control-label text-right ">Valor</label>
                                        <input type="text" id="facturap4_valor" name="facturap4_valor" class="input-sm form-control" data-currency>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="facturap4_valor_porcentaje" class="control-label text-right ">Porcentaje</label>
                                        <br>
                                        <input type="text" id="facturap4_valor_porcentaje" name="facturap4_valor_porcentaje" class="input-sm form-control spinner-percentage" value="0">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="facturap4_valor_porcion" class="control-label text-right ">Porción</label>
                                        <input type="number" id="facturap4_valor_porcion" name="facturap4_valor_porcion" min="1" class="input-sm form-control">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <br>
                                        <button type="submit" class="btn btn-success btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive no-padding">
                                <table id="browse-centro-facturap4-list" class="table table-hover table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%"></th>
                                            <th width="45%">Unidad de desición</th>
                                            <th width="45%">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content detalle --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-right">Total</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Tab contabilidad -->
                        <div id="tab_contabilidad" class="tab-pane">
                            Contabilidad
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-4 col-md-6 col-xs-6 text-left">
                                    <a href="{{ route('facturasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                                </div>
                                <div class="col-md-2 col-xs-6 text-right">
                                    <button type="button" class="btn btn-primary btn-sm btn-block submit-facturap">{{ trans('app.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </script>
    <script type="text/template" id="add-factura2-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detallefacturap2-remove" data-resource = "<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- centrocosto_nombre %></td>
        <td><%- facturap4_valor %></td>
    </script>
    <script type="text/template" id="add-factura4-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-centrofacturap4-remove" data-resource = "<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- (impuesto_nombre != null ) ? impuesto_nombre : retefuente_nombre %></td>
        <td><%- facturap2_porcentaje %></td>
        <td><%- window.Misc.currency (facturap2_base) %></td>
    </script>
    <script type="text/template" id="add-activofijo-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-removeactivofijo-remove" data-resource = "<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td><%- activofijo_placa %></td>
        <% }else{ %>
            <td> <a href="<%- window.Misc.urlFull( Route.route('activosfijos.show', { activosfijos: id } )) %>" title="Ver documento" target="_blank"> <%- activofijo_placa %></a></td>
        <%} %>
        <td><%- activofijo_serie %></td>
        <td><%- tercero_nombre %></td>
        <td><%- tipoactivo_nombre %></td>
        <td><%- window.Misc.currency(activofijo_costo) %></td>
    </script>

    <script type="text/template" id="add-entrada-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-entrada-remove" data-resource = "<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>

        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>
        <td><%- entrada2_cantidad %></td>
        <td><%- window.Misc.currency(entrada2_costo) %></td>
    </script>
@stop
