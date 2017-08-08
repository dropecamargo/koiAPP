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
                <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-facturap" data-toggle="tab">Factura</a></li>
                        <% if( typeof(edit) !== 'undefined' && !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                            <li><a href="#tab-impuesto" data-toggle="tab">Impuesto/Retención</a></li>
                            <li><a href="#tab-contabilidad" data-toggle="tab">Contabilidad</a></li>
                            <li><a href="#tab-af" data-toggle="tab">Activos/Efectivos</a></li>
                        <% }%>
                    </ul>
                    <div class="tab-content">
                        <!-- Tab factura proveedor -->
                        <div id="tab-facturap" class="tab-pane active">
                            <div class="box-body">
                                <% if (!_.isUndefined(edit) && !_.isNull(edit) && !edit ){ %> 
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
                                                    <input id="facturap1_tercero" placeholder="Cliente" class="form-control tercero-koi-component aaa" name="facturap1_tercero" type="text" maxlength="15" data-wrapper="anticipo-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-xs-12">
                                                <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="facturap1_factura" class="control-label col-md-1">Factura</label>
                                            <div class="form-group col-md-3">
                                                <input type="text" id="facturap1_factura" name="facturap1_factura" class="form-control input-sm input-toupper" maxlength="20" value="<%- facturap1_factura %>" placeholder="Factura" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="facturap1_fecha" class="col-md-1 control-label">Fecha</label>
                                            <div class="form-group col-md-2">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" id="facturap1_fecha" name="facturap1_fecha" class="form-control input-sm datepicker" value="<%- facturap1_fecha %>" required>
                                                </div>
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
                                            <label for="facturap1_tipoproveedor" class="control-label col-md-1">Tipo proveedor</label>
                                            <div class="form-group col-md-3">
                                                <select id="facturap1_tipoproveedor" name="facturap1_tipoproveedor" class="form-control select2-default-clear">
                                                    @foreach( App\Models\Tesoreria\TipoProveedor::getTiposProveedores() as $key => $value)
                                                        <option  value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label for="facturap1_tipogasto" class="control-label col-md-1">Tipo gasto</label>
                                            <div class="form-group col-md-3">
                                                <select id="facturap1_tipogasto" name="facturap1_tipogasto" class="form-control select2-default-clear">
                                                    @foreach( App\Models\Tesoreria\TipoGasto::getTiposGastos() as $key => $value)
                                                        <option  value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
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
                                            <label for="facturap1_observaciones" class="col-md-1 control-label">Observaciones</label>
                                            <div class="form-group col-md-10">
                                                <textarea id="facturap1_observaciones" name="facturap1_observaciones" class="form-control" rows="2" placeholder="Observaciones factura proveedor"><%- facturap1_observaciones %></textarea>
                                            </div>
                                        </div>
                                    </form>
                                <% }else{ %> 
                                    <div class="row">
                                        <label for = "facturap1_regional" class="control-label col-md-1">Regional</label>
                                        <div class="form-group col-md-3">
                                            <%- regional_nombre %>
                                        </div>
                                        <label for="facturap1_numero" class="col-md-1 control-label">Número</label>
                                        <div class="form-group col-md-1">     
                                            <%- facturap1_numero %>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="facturap1_tercero" class="col-md-1 control-label">Cliente</label>
                                        <div class="form-group col-md-3">
                                            <%- tercero_nombre %>
                                        </div>
                                        <label for="facturap1_tercero" class="col-md-1 control-label">Persona</label>
                                        <div class="form-group col-md-2">
                                            <%- (tercero_persona == 'N') ? 'NATURAL' : 'JURIDICA' %>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="facturap1_factura" class="control-label col-md-1">Factura</label>
                                        <div class="form-group col-md-3">
                                            <%- facturap1_factura %>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="facturap1_fecha" class="col-md-1 control-label">Fecha</label>
                                        <div class="form-group col-md-3">
                                            <%- facturap1_fecha %>
                                        </div>

                                        <label for="facturap1_vencimiento" class="control-label col-md-1">Vencimiento</label>
                                        <div class="form-group col-md-2">
                                            <%- facturap1_vencimiento %>
                                        </div>
                                        <label for="facturap1_primerpago" class="control-label col-md-1">Primer pago</label>
                                        <div class="form-group col-md-2">
                                            <%- facturap1_primerpago %>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="facturap1_tipoproveedor" class="control-label col-md-1">Tipo proveedor</label>
                                        <div class="form-group col-md-3">
                                            <%- tipoproveedor_nombre %>
                                        </div>
                                        <label for="facturap1_tipogasto" class="control-label col-md-1">Tipo gasto</label>
                                        <div class="form-group col-md-2">
                                            <%- tipogasto_nombre %>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="facturap1_cuotas" class="control-label col-md-1">Cuota</label>
                                        <div class="form-group col-md-3">
                                            <%- facturap1_cuotas %>
                                        </div>
                                        <label for="facturap1_subtotal" class="control-label col-md-1">Subtotal</label>
                                        <div class="form-group col-md-2">
                                            <%- window.Misc.currency( facturap1_subtotal ) %>
                                        </div>                    
                                        <label for="facturap1_descuento" class="control-label col-md-1">Descuento</label>
                                        <div class="form-group col-md-2">
                                            <%- window.Misc.currency( facturap1_descuento ) %>
                                        </div>                    
                                    </div> 
                                    <div class="row">
                                        <label for="facturap1_observaciones" class="col-md-1 control-label">Observaciones</label>
                                        <div class="form-group col-md-10">
                                            <%- facturap1_observaciones %>
                                        </div>
                                    </div>
                                <% }%>
                            </div>
                        </div>
                        <% if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                            <!-- Tab impuesto -->
                            <div id="tab-impuesto" class="tab-pane">
                                <div class="box box-solid">
                                    <div class="box-body">
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
                                </div>
                            </div>
                            <!-- Tab contabilidad -->
                            <div id="tab-contabilidad" class="tab-pane">
                                Contabilidad
                            </div>
                            <!-- Tab activos & efectivos -->
                            <div id="tab-af"  class="tab-pane">
                                Actiovs y efectivos
                            </div>
                        <% } %>
                        <div class="box-footer">
                            <div class="row">
                                <% if (!_.isUndefined(edit) && !_.isNull(edit) && !edit ){ %> 
                                    <div class="col-md-2 col-md-offset-4 col-md-6 col-xs-6 text-left">
                                        <a href="{{ route('facturasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                                    </div>
                                    <div class="col-md-2  col-md-5 col-xs-6 text-right">
                                        <button type="button" class="btn btn-primary btn-sm btn-block submit-facturap">{{ trans('app.save') }}</button>
                                    </div>
                                <% }else{%> 
                                    <div class="col-md-2 col-md-offset-5 col-md-6 col-xs-6">
                                        <a href="{{ route('facturasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                                    </div>
                                <% } %>
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
        <td><%- (facturap2_impuesto != null ) ? impuesto_nombre : retefuente_nombre %></td>
        <td><%- facturap2_porcentaje %></td>
        <td><%- facturap2_base %></td>
    </script>
@stop