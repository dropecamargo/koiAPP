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
                    <div class="form-group col-sm-2">
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
                        <select name="factura1_sucursal" id="factura1_sucursal" class="form-control" data-wrapper="factura-create">
                        </select>
                    </div>
                    <label for="factura1_fecha" class="col-sm-1 col-md-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">
                        <input type="text" id="factura1_fecha" name="factura1_fecha" value="<%- factura1_fecha %>" class="form-control input-sm datepicker" required>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_tercero" class="col-sm-1 col-md-1 control-label">Cliente</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="factura1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="factura1_tercero" placeholder="Cliente" class="form-control tercero-koi-component tercero-factura-change-koi" name="factura1_tercero" type="text" maxlength="15" data-formapago="factura1_formapago" data-plazo="factura1_plazo" data-punto="factura1_puntoventa" data-cuotas="factura1_cuotas" data-primerpago="factura1_primerpago" data-contacto="btn-add-contact" data-nameTC="tcontacto_nombre" data-dirTC="tcontacto_direccion" data-change="true" data-wrapper="factura-create" data-cliente="true" data-name="factura1_terecero_nombre" value="<%- tercero_nit %>" data-vendedorT="factura1_vendedor" data-sucursalP="factura1_sucursal" data-obs="factura1_observaciones" data-address="tercero_direccion" required>
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
                    <div class="form-group col-sm-4">
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
                    <label for="factura1_formapago" class="col-sm-1 col-md-1 control-label">Pago</label>
                    <div class="form-group col-sm-2">
                        <input name="factura1_formapago" id="factura1_formapago" class="form-control" required>
                    </div>                                           
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
                        <input type="text" id="factura1_primerpago" name="factura1_primerpago" value="<%- factura1_primerpago %>" class="form-control input-sm datepicker" required>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_vendedor" class="col-sm-1 col-md-1 control-label">Vendedor</label>
                    <div class="form-group col-sm-4">
                        <select name="factura1_vendedor" id="factura1_vendedor" class="form-control" placeholder="Nombre Vendedor"></select>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_observaciones" class="col-sm-1 col-md-1 control-label">Observaciones</label>
                    <div class="form-group col-md-10">
                        <textarea id="factura1_observaciones" name="factura1_observaciones" class="form-control" rows="2" placeholder="Observaciones"><%- factura1_observaciones %></textarea>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('pedidosc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-pedidosc">{{ trans('app.save') }}</button>
                </div>
            </div>
            <br>
            <div id="detalle-factura1">
                <!-- Render tpl search and tpl factura1-->
            </div>
            <div class="table-responsive no-padding">
                <table id="browse-detalle-factura-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th width="10%">Referencia</th>
                            <th width="35%">Nombre</th>
                            <th width="3%">Cant</th>
                            <th width="15%">Precio</th>
                            <th width="15%">Descuento</th>
                            <th width="9%">Iva</th>
                            <th  width="10%">Total</th>
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

    <script type="text/template" id="add-pedidoc-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detalleajuste-remove" data-resource = "<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>
        <td><%- factura2_cantidad %></td>
        <td><%- window.Misc.currency(factura2_costo) %></td>
        <td><%- window.Misc.currency(factura2_descuento_valor) %></td>
        <td><%- factura2_iva_porcentaje %></td>
        <td><%- window.Misc.currency(factura2_subtotal) %></td>
    </script>
@stop