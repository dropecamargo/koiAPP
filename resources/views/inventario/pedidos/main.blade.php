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
        <div class="box-body" id="render-form-pedido">
           
            <form method="POST" accept-charset="UTF-8" id="form-pedido" data-toggle="validator">
                <div class="row">
                    <label for="pedido1_sucursal" class="col-sm-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-2 col-xs-10">
                        <select name="pedido1_sucursal" id="pedido1_sucursal" class="form-control select2-default-clear">
                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                        <option value="{{ $key }}" <%- pedido1_sucursal == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                    <label for="pedido1_numero" class="col-sm-2 control-label">Número</label>
                    <div class="form-group col-sm-2">     
                        <input id="pedido1_numero" name="pedido1_numero" placeholder="Número" class="form-control input-sm" type="number" min="1" value="<%- pedido1_numero %>" required readonly>
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
                        <input type="text" id="pedido1_anticipo" name="pedido1_anticipo" class="form-control input-sm" value="<%- pedido1_anticipo %>" required data-currency>
                    </div> 
                </div>

                <div class="row">
                    <label for="pedido1_tercero" class="col-sm-1  control-label">Cliente</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="pedido1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="pedido1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="pedido1_tercero" type="text" maxlength="15" data-wrapper="pedido-create" data-name="pedido1_terecero_nombre" data-contacto="btn-add-contact" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-10">
                        <input id="pedido1_terecero_nombre" name="pedido1_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>               
                </div> 

                <div class="row">
                    <label for="pedido1_observaciones" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-md-6">
                        <textarea id="pedido1_observaciones" name="pedido1_observaciones" class="form-control" rows="2" placeholder="Observaciones Pedidos"><%- pedido1_observaciones %></textarea>
                    </div>
                </div>
            </form>
            
           
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('pedidos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-5 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-pedido">{{ trans('app.save') }}</button>
                </div>
            </div><br>
            <div id="detalle-pedido" >
                <div class="box box-success">
                    <form method="POST" accept-charset="UTF-8" id="form-detalle-pedido" data-toggle="validator"><br>
                        <div class="row">
                            <div class="form-group col-sm-2 col-md-offset-1">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="sirvea_codigo">
                                            <i class="fa fa-barcode"></i>
                                        </button>
                                    </span>
                                    <input id="sirvea_codigo" placeholder="Serie" class="form-control producto-koi-component" name="sirvea_codigo" type="text" maxlength="15" data-wrapper="producto_create" data-tipo="" data-name="sirvea_codigo_nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-10">
                                <input id="sirvea_codigo_nombre" name="sirvea_codigo_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                            </div>
                             <div class="col-sm-2 col-xs-10">
                                <input id="sirvea_codigo_nombre" name="sirvea_codigo_nombre" placeholder="Referencia Producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                            </div>
                            <div class="form-group col-sm-1">
                                <button type="submit" class="btn btn-success btn-sm btn-block">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-sm-1 col-md-offset-3">Cantidad</label>
                                <div class="col-sm-1 col-xs-10">
                                    <input id="pedido2_cantidad" name="pedido2_cantidad" min="1" class="form-control input-sm" type="number" required>
                                </div>
                            <label class="control-label col-sm-1">Precio</label>
                                <div class="col-sm-2 col-xs-10">
                                    <input id="pedido2_precio" name="pedido2_precio" class="form-control input-sm" type="text" data-currency required>
                                </div>
                        </div><br>
                    </form>
                    <div class="table-responsive no-padding">
                        <table id="browse-detalle-pedido-list" class="table table-hover table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5px"></th>
                                    <th width="5px">Serie</th>
                                    <th width="95px">Nombre</th>
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
    </script>
    <script type="text/template" id="add-pedidodetalle-item-tpl">
        <td class="text-center">
            <a class="btn btn-default btn-xs item-visita-remove" data-resource="<%- id %>">
                <span><i class="fa fa-times"></i></span>
            </a>
        </td>
    
        <td></td>
        <td></td>
        
        </td>
    </script>
@stop