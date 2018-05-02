@extends('layout.layout')

@section('title') Facturas @stop

@section('content')
    <section class="content-header">
        <h1>
            Facturas <small>Administración de facturas </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-facturas-tpl" >
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-factura1" data-toggle="validator">
                <div class="row">
                    <label for="factura1_puntoventa" class="col-sm-1 col-md-1 control-label">Punto Venta</label>
                    <div class="form-group col-sm-3">
                        <select name="factura1_puntoventa" id="factura1_puntoventa" class="form-control select2-default change-puntoventa-consecutive-koi-component" data-wrapper="factura-create" data-field="factura1_numero" >
                            @foreach( App\Models\Base\PuntoVenta::getPuntosVenta() as $key => $value)
                                <option  value="{{ $key }}" <%- factura1_puntoventa == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="factura1_numero" class="col-sm-1 col-md-1 control-label">Número</label>
                    <div class="form-group col-sm-1 col-md-1">
                        <input id="factura1_numero" name="factura1_numero" class="form-control input-sm" type="number" min="1" value="<%- factura1_numero %>" required readonly>
                    </div>
                    <label for="factura1_sucursal" class="col-sm-1 col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-2">
                        <select name="factura1_sucursal" id="factura1_sucursal" class="form-control select2-default-clear" data-wrapper="factura-create">
                            @if(!session('empresa')->empresa_pedidoc)
                                @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                    <option  value="{{ $key }}" <%- factura1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <label for="factura1_fecha" class="col-sm-1 col-md-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="factura1_fecha" name="factura1_fecha" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker-back" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_tercero" class="col-sm-1 col-md-1 control-label">Cliente</label>
                    <div class="form-group col-sm-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="factura1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            @if(!session('empresa')->empresa_pedidoc)
                                <input id="factura1_tercero"  name="factura1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" data-wrapper="factura-create" data-name="factura1_terecero_nombre" data-address="tercero_direccion" data-contacto="btn-add-contact" value="<%- tercero_nit %>"required>
                            @else
                                <input id="factura1_tercero" placeholder="Cliente" class="form-control tercero-koi-component tercero-factura-change-koi" name="factura1_tercero" type="text" maxlength="15" data-formapago="factura1_formapago" data-plazo="factura1_plazo" data-punto="factura1_puntoventa" data-cuotas="factura1_cuotas" data-primerpago="factura1_primerpago" data-contacto="btn-add-contact" data-idTC ="factura1_tercerocontacto" data-nameTC="tcontacto_nombre" data-dirTC="tcontacto_direccion" data-change="true" data-wrapper="factura-create" data-name="factura1_terecero_nombre" value="<%- tercero_nit %>" data-vendedorT="factura1_vendedor" data-numPedido="factura1_pedido" data-sucursalP="factura1_sucursal" data-obs="factura1_observaciones" data-address="tercero_direccion" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-10">
                        <input id="factura1_terecero_nombre" name="factura1_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                    <div class="col-sm-4 col-xs-10">
                        <input id="tercero_direccion" name="tercero_direccion" placeholder="Dirección cliente" class="form-control input-sm" type="text" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="tcontacto_nombre" class="col-sm-1 col-md-1 control-label">Contacto</label>
                    <div class="form-group col-sm-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-contacto-component-table" data-field="factura1_tercerocontacto" data-name="tcontacto_nombre" data-address="tcontacto_direccion" id="btn-add-contact">
                                    <i class="fa fa-address-book"></i>
                                </button>
                            </span>
                            <input id="factura1_tercerocontacto" name="factura1_tercerocontacto" type="hidden" value="<%- factura1_tercerocontacto %>">
                            <input id="tcontacto_nombre" placeholder="Contacto" class="form-control" name="tcontacto_nombre" type="text" value="<%- contacto_nombre %>" readonly required>
                        </div>
                    </div>
                    <label for="tcontacto_direccion" class="col-sm-2 control-label"> Dirección de despacho</label>
                    <div class="col-sm-4 col-xs-10">
                        <input id="tcontacto_direccion" name="tcontacto_direccion" placeholder="Direccion contacto" class="form-control input-sm" type="text" readonly required>
                    </div>
                </div>
                <div class="row">
                    @if(session('empresa')->empresa_pedidoc)
                        <label for="factura1_pedido" class="col-sm-1 col-md-1 control-label">N° Pedido</label>
                        <div class="form-group col-sm-1">
                            <input name="factura1_pedido" id="factura1_pedido" class="form-control" readonly required>
                        </div>
                        <label for="factura1_formapago" class="col-sm-1 col-md-1 control-label">Pago</label>
                        <div class="form-group col-sm-2">
                            <input name="factura1_formapago" id="factura1_formapago" class="form-control" required>
                        </div>
                    @endif
                    <label for="factura1_plazo" class="col-sm-1 col-md-1 control-label">Plazo</label>
                    <div class="form-group col-sm-1 col-md-1">
                        <input id="factura1_plazo" name="factura1_plazo" class="form-control input-sm" type="number" min="0"  required>
                    </div>

                    <label for="factura1_cuotas" class="col-sm-1 col-md-1 control-label">Cuotas</label>
                    <div class="form-group col-sm-1 col-md-1">
                        <input id="factura1_cuotas" name="factura1_cuotas" class="form-control input-sm" type="number" min="0" required>
                    </div>

                    <label for="factura1_primerpago" class="col-sm-1 col-md-1 control-label">Primer Pago</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="factura1_primerpago" name="factura1_primerpago" value="<%- factura1_primerpago %>" class="form-control input-sm datepicker" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_vendedor" class="col-sm-1 col-md-1 control-label">Vendedor</label>
                    <div class="form-group col-sm-6">
                        <select name="factura1_vendedor" id="factura1_vendedor" class="form-control select2-default-clear" placeholder="Nombre Vendedor">
                            @if(!session('empresa')->empresa_pedidoc)
                                @foreach( App\Models\Base\Tercero::getSellers() as $key => $value)
                                    <option  value="{{ $key }}" <%- factura1_vendedor == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_observaciones" class="col-sm-1 col-md-1 control-label">Observaciones</label>
                    <div class="form-group col-md-11">
                        <textarea id="factura1_observaciones" name="factura1_observaciones" class="form-control" rows="2" placeholder="Observaciones"><%- factura1_observaciones %></textarea>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-factura">{{ trans('app.save') }}</button>
                </div>
            </div>
            @if(!session('empresa')->empresa_pedidoc)
                <div id="detalle-factura1">
                    <div class="box-body box-solid">
                        <form method="POST" accept-charset="UTF-8" id="form-detalle-factura" data-toggle="validator">
                            <div class="row">
                                <label  class="control-label col-md-1 col-md-1">Producto</label>
                                <div class="form-group col-md-2">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_serie">
                                                <i class="fa fa-barcode"></i>
                                            </button>
                                        </span>
                                        <input id="producto_serie" placeholder="Serie" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="factura-create" data-name="producto_nombre" data-ref="false" data-price="factura2_costo" data-office = "factura1_sucursal" data-pedidoc="false" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm input-toupper" type="text" maxlength="100" required readonly>
                                </div>

                                <label for="factura2_cantidad" class="col-xs-6 col-md-1 col-md-1 control-label">Cantidad </label>
                                <div class="col-xs-6 col-md-1 col-md-1 form-group">
                                    <input type="number" name="factura2_cantidad" id="factura2_cantidad"  class="form-control  input-sm" required min="1">
                                </div>

                                <label for="factura2_costo" class="col-xs-6 col-md-1 col-md-1 control-label">Precio </label>
                                <div class="form-group col-xs-6 col-md-2">
                                    <input type="text" name="factura2_costo" id="factura2_costo" class="form-control input-sm" data-currency  required>
                                </div>
                            </div>
                            <div id="wrapper-discount" class="row">
                                <label class="col-xs-12 col-md-1 col-md-1 control-label">Descuento</label>
                                <div class="form-group col-xs-8 col-md-1 col-md-1">
                                    <input type="text" id="factura2_descuento_porcentaje" name="factura2_descuento_porcentaje" class="spinner-percentage  input-sm form-control desc-porcentage" min="0"  max ="100" value="0" required>
                                </div>
                                <div class="col-xs-4 col-md-1 col-md-1">
                                    <label class="radio-inline without-padding">
                                        <input type="radio" id="desc_porcentage"  class="desc" checked name="radio_naturaleza_descuento"> <b>%</b>
                                    </label>
                                </div>
                                <div class="col-xs-8 col-md-2 col-md-2 form-group">
                                    <input type="text" id="factura2_descuento_valor" name="factura2_descuento_valor" value="0" class="form-control input-sm desc-value" data-currency-price required>
                                </div>
                                <div class="col-xs-4 col-md-1 col-md-1">
                                    <label class="radio-inline without-padding">
                                        <input type="radio" id="desc_value" class="desc" name="radio_naturaleza_descuento"> <b>Valor</b>
                                    </label>
                                </div>

                                <div class="form-group col-xs-8 col-md-2 col-md-2">
                                    <input type="text" id="factura2_precio_venta" name="factura2_precio_venta" value="0" class="form-control input-sm desc-finally" data-currency-price required>
                                </div>
                                <div class="col-xs-4 col-md-1 col-md-1">
                                    <label class="radio-inline without-padding">
                                        <input type="radio" id="desc_finally" class="desc" name="radio_naturaleza_descuento"> <b>Final</b>
                                    </label>
                                </div>
                                <label class="col-xs-12 col-md-1 col-md-1 control-label">Iva</label>
                                <div class="form-group col-md-1 col-md-1">
                                    <input type="text" class="input-sm form-control spinner-percentage" min="0" id="factura2_iva_porcentaje" name="factura2_iva_porcentaje" required>
                                </div>
                                <div class="col-md-1 col-md-1">
                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="table-responsive no-padding">
                <table id="browse-detalle-factura-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="10%">Referencia</th>
                            <th width="40%">Nombre</th>
                            <th width="5%">Cant</th>
                            <th width="10%">Precio</th>
                            <th width="10%">Descuento</th>
                            <th width="10%">Iva</th>
                            <th width="10%">Total</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total: </th>
                            <th id="precio-product"></th>
                            <th id="descuento-product"></th>
                            <th id="iva-product"></th>
                            <th id="totalize-product"></th>
                        </tr>
                    </tfoot>

                    <tbody>
                        {{-- Render content detalle factura --}}
                    </tbody>
                </table>
            </div>
        </div>
    </script>

@stop
