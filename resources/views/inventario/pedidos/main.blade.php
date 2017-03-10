@extends('layout.layout')

@section('title') Pedidos @stop

@section('content')
    <section class="content-header">
        <h1>
            Pedidos <small>Administración de Pedidos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-pedido-tpl">
        <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_pedido" data-toggle="tab">Pedido</a></li>
               
                <%if(edit){ %> 
                    <li><a href="#tab_bitacora" data-toggle="tab">Bitácora</a></li>
                
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="#" class="close-pedido">
                                    <i class="fa fa-lock"></i>Cerrar Pedido
                                </a>
                                <a role="menuitem" tabindex="-1" href="#" class="cancel-pedido">
                                    <i class="fa fa-times"></i>Anular Pedido
                                </a>
                            </li>
                        </ul>
                    </li>
                <% } %>
            </ul><br>
            <div class="tab-content">
                {{-- Content pedidos --}}
                <div class="tab-pane active" id="tab_pedido">
                    <div class="box box-whithout-border">
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-pedido" data-toggle="validator">
                                <div class="row">
                                    <label for="pedido1_sucursal" class="col-sm-1 control-label">Sucursal</label>
                                    <div class="form-group col-sm-3">
                                        <select name="pedido1_sucursal" id="pedido1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-field="pedido1_numero" data-document ="pedido" data-wrapper="pedido-create">
                                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                        <option  value="{{ $key }}" <%- pedido1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <label for="pedido1_numero" class="col-sm-1 control-label">Número</label>
                                    <div class="form-group col-sm-1">     
                                        <input id="pedido1_numero" name="pedido1_numero" class="form-control input-sm" type="number" min="1" value="<%- pedido1_numero %>" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="pedido1_fecha" class="col-sm-1  control-label">Fecha</label>
                                    <div class="form-group col-sm-2 ">
                                        <input type="text" id="pedido1_fecha" name="pedido1_fecha" class="form-control input-sm datepicker" value="<%- pedido1_fecha %>" required>
                                    </div> 
                                    <label for="pedido1_fecha_estimada" class="col-sm-2 control-label">Fecha Estimada De Llegada</label>
                                    <div class="form-group col-sm-2 ">
                                        <input type="text" id="pedido1_fecha_estimada" name="pedido1_fecha_estimada" class="form-control input-sm datepicker" value="<%- pedido1_fecha_estimada %>" required>
                                    </div> 
                                </div>
                                     
                                <div class="row">
                                    <label for="pedido1_fecha_anticipo" class="col-sm-1  control-label">Fecha Anticipo</label>
                                    <div class="form-group col-sm-2">
                                        <input type="text" id="pedido1_fecha_anticipo" name="pedido1_fecha_anticipo" class="form-control input-sm datepicker" value="<%- pedido1_fecha_anticipo %>" required>
                                    </div> 
                                    <label for="pedido1_anticipo" class="col-sm-2 control-label">Valor Antcipo</label>
                                    <div class="form-group col-sm-2 ">
                                        <input type="text" id="pedido1_anticipo" name="pedido1_anticipo" class="form-control input-sm" value="<%- pedido1_anticipo %>" required data-currency-precise>
                                    </div> 
                                </div>

                                <div class="row">
                                    <label for="pedido1_tercero" class="col-sm-1  control-label">Cliente</label>
                                    <div class="form-group col-sm-3">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="pedido1_tercero" <%- edit ? 'disabled': ''%>>
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </span>
                                            <input id="pedido1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="pedido1_tercero" type="text" maxlength="15" data-wrapper="pedido-create" data-name="pedido1_terecero_nombre" data-contacto="btn-add-contact" value="<%- tercero_nit %>" required <%- edit ? 'readonly': ''%>>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <input id="pedido1_terecero_nombre" name="pedido1_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                                    </div>               
                                </div> 

                                <div class="row">
                                    <label for="pedido1_observaciones" class="col-sm-1 control-label">Observaciones</label>
                                    <div class="form-group col-md-10">
                                        <textarea id="pedido1_observaciones" name="pedido1_observaciones" class="form-control" rows="2" placeholder="Observaciones Pedidos"><%- pedido1_observaciones %></textarea>
                                    </div>
                                </div>
                        <% if(edit){ %>
                            </form> 
                        <% } %>
                                
                            <div class="row">
                                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                                    <a href="{{ route('pedidos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                                </div>
                        <% if(edit) { %>
                            <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm btn-block submit-pedido">{{ trans('app.save') }}</button>
                            </div>
                        <% } %>
                            </div><br>
                            <div class="box box-success">
                                <% if(edit){ %> 
                                    <form method="POST" accept-charset="UTF-8" id="form-detalle-pedido" data-toggle="validator">
                                <% } %>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group col-sm-2 col-md-offset-2">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_pedido2">
                                                            <i class="fa fa-barcode"></i>
                                                        </button>
                                                    </span>
                                                    <input id="producto_pedido2" placeholder="Serie" class="form-control producto-koi-component" name="producto_pedido2" type="text" maxlength="15" data-wrapper="pedido-create" data-tipo="" data-name="producto_pedido2_nombre" data-ref="true" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 ">
                                                <input id="producto_pedido2_nombre" name="producto_pedido2_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                                            </div>
                                            <div class="form-group col-sm-1 ">
                                                <button type="submit" class="btn btn-success btn-sm btn-block">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
             
                                        <div class="row">
                                            <label class="control-label col-sm-1 col-md-offset-3">Cantidad</label>
                                            <div class="col-sm-1">
                                                <input id="pedido2_cantidad" name="pedido2_cantidad" min="1" class="form-control input-sm" type="number" required>
                                            </div>
                                            <label class="control-label col-sm-1">Precio</label>
                                            <div class="col-sm-2">
                                                <input id="pedido2_precio" name="pedido2_precio" class="form-control input-sm" type="text" data-currency required>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </form>

                                <div class="table-responsive no-padding">
                                    <table id="browse-detalle-pedido-list" class="table table-hover table-bordered" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="15%">Referencia</th>
                                                <th width="50%">Nombre</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="15%">Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Render content detalle pedido --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Content bitacora --}}
                <% if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                    <div class="tab-pane" id="tab_bitacora">
                        <div class="box box-whithout-border" id="wrapper-bitacora">
                            <div class="box-body">
                                <div class="table-responsive no-padding">
                           
                                    <table id="browse-bitacora-list" class="table table-hover table-bordered" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="25%">Nombre</th>
                                                <th width="20%">Campo</th>
                                                <th width="20%">Anterior</th>
                                                <th width="20%">Nuevo</th>
                                                <th width="15%">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Render content item bitacora --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <% } %>
            </div>      
        </div>
   
    </script>

    <script type="text/template" id="add-pedidodetalle-item-tpl">
        <% if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detallepedido-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>
        <td><%- pedido2_cantidad %></td>
        <td><%- window.Misc.currency(pedido2_precio) %></td>
    </script>

    <script type="text/template" id="pedido-close-confirm-tpl">
        <p>¿Está seguro que desea cerrar el pedido de mercancía <b><%- id_pedido %></b>?</p>
    </script>
@stop