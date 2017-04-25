@extends('layout.layout')

@section('title') Pedidos @stop

@section('content')
    <section class="content-header">
        <h1>
            Pedidos comercial <small>Administración de pedidos </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-pedidosc-tpl" >
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-pedidoc1" data-toggle="validator">
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="pedidoc1_sucursal" class="control-label">Sucursal</label>
                        <select name="pedidoc1_sucursal" id="pedidoc1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-field="pedidoc1_numero" data-document ="pedidoc" data-wrapper="pedidoc1-create">
                            @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- pedidoc1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-1">     
                        <label for="pedidoc1_numero" class="control-label">Número</label>
                        <input id="pedidoc1_numero" name="pedidoc1_numero" class="form-control input-sm" type="number" min="1" value="<%- pedidoc1_numero %>" required readonly>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="pedidoc1_fecha" class="control-label">Fecha</label>
                        <input type="text" id="pedidoc1_fecha" name="pedidoc1_fecha" value="<%- pedidoc1_fecha %>" class="form-control input-sm datepicker" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="pedidoc1_tercero" class="control-label">Cliente</label>
                        <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="pedidoc1_tercero">
                                <i class="fa fa-user"></i>
                            </button>
                        </span>
                        <input id="pedidoc1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="pedidoc1_tercero" type="text" maxlength="15" data-contacto="btn-add-contact" data-wrapper="pedidoc1-create" data-cliente="true" data-name="pedidoc1_terecero_nombre" value="<%- tercero_nit %>" data-address="tercero_direccion" required>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-10"><br>
                        <input id="pedidoc1_terecero_nombre" name="pedidoc1_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>  
                    <div class="col-sm-4 col-xs-10">
                        <label for="tercero_direccion"> Dirección</label>
                        <input id="tercero_direccion" name="tercero_direccion" placeholder="Dirección cliente" class="form-control input-sm" type="text" readonly required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4 col-xs-10">
                        <label for="tcontacto_nombre" class="control-label">Contacto</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-contacto-component-table" data-field="pedidoc1_contacto" data-name="tcontacto_nombre" data-phone="tcontacto_telefono" data-address="tcontacto_direccion" data-tercero="btn-add-contact">
                                    <i class="fa fa-address-book"></i>
                                </button>
                            </span>
                            <input id="pedidoc1_contacto" name="pedidoc1_contacto" type="hidden" value="<%- pedidoc1_contacto %>">
                            <input id="tcontacto_nombre" placeholder="Contacto" class="form-control" name="tcontacto_nombre" type="text" value="<%- contacto_nombre %>" readonly required>
                        </div>
                    </div>  
                    <div class="col-sm-4 col-xs-10">
                        <label for="tcontacto_direccion"> Dirección de despacho</label>
                        <input id="tcontacto_direccion" name="tcontacto_direccion" placeholder="Direccion contacto" class="form-control input-sm" type="text" readonly required>
                    </div>
                    <div class="col-sm-1 col-xs-2"><br>
                        <button type="button" id="btn-add-contact" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="contacto" data-field="pedidoc1_contacto" data-name="tcontacto_nombre" data-tercero="<%- pedidoc1_tercero %>" data-phone="tcontacto_telefono">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="pedidoc1_formapago" class="control-label">Pago</label>
                        <select name="pedidoc1_formapago" id="pedidoc1_formapago" class="form-control" required>
                            @foreach( config('koi.produccion.formaspago') as $key => $value)
                                <option value="{{ $key }}" <%- pedidoc1_formapago == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>                                           
                    <div class="form-group col-sm-1">     
                        <label for="pedidoc1_plazo" class="control-label">Plazo</label>
                        <input id="pedidoc1_plazo" name="pedidoc1_plazo" class="form-control input-sm" type="number" min="1"  required>
                    </div>

                    <div class="form-group col-sm-1">     
                        <label for="pedidoc1_plazo" class="control-label">Cuotas</label>
                        <input id="pedidoc1_cuota   " name="pedidoc1_cuota" class="form-control input-sm" type="number" min="1" required>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="pedidoc1_primerpago" class="control-label">Primer Pago</label>
                        <input type="text" id="pedidoc1_primerpago" name="pedidoc1_primerpago" value="<%- pedidoc1_primerpago %>" class="form-control input-sm datepicker" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="pedidoc1_vendedor" class="control-label">Vendedor</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="pedidoc1_vendedor">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="pedidoc1_vendedor" placeholder="Vendedor" class="form-control tercero-koi-component" name="pedidoc1_vendedor" type="text" maxlength="15" data-wrapper="pedidoc1-create" data-name="pedidoc1_vendedor_nombre" data-vendedor="true" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-10"><br>
                        <input id="pedidoc1_vendedor_nombre" name="pedidoc1_vendedor_nombre" placeholder="Nombre vendedor" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div> 
                </div>
                <div class="row">
                    <div class="form-group col-md-10">
                        <label for="pedidoc1_observaciones" class="control-label">Observaciones</label>
                        <textarea id="pedidoc1_observaciones" name="pedidoc1_observaciones" class="form-control" rows="2" placeholder="Observaciones"><%- pedidoc1_observaciones %></textarea>
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
            <div id="detalle-pedidoc1">
                <!-- Render tpl search and tpl pedidoc2-->
            </div>
            <div class="table-responsive no-padding">
                <table id="browse-detalle-pedidoc-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="10%">Referencia</th>
                            <th width="30%">Nombre</th>
                            <th width="10%">Cantidad</th>
                            <th width="15%">Precio</th>
                            <th width="15%">Descuento</th>
                            <th width="5%">Iva</th>
                            <th width="15%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Render content detalle pedidoc --}}
                    </tbody>
                </table>
            </div
        </div>
    </script>

    <script type="text/template" id="add-detailt-pedidosc-tpl">
        <div class="box-body box box-success">
            <form method="POST" accept-charset="UTF-8" id="form-detalle-pedidoc" data-toggle="validator">
                <div class="row">
                    <div class="form-group col-sm-2 col-md-offset-1">
                        <label  class="control-label">Producto</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_serie">
                                    <i class="fa fa-barcode"></i>
                                </button>
                            </span>
                            <input id="producto_serie" placeholder="Serie" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="pedidosc-create" data-name="producto_nombre" required> 
                        </div>
                    </div>
                    <div class="col-sm-5 "><br>
                        <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                    </div>
                    <div class="col-sm-1">
                        <label for="pedidoc2_cantidad" class="control-label">Cantidad </label>
                        <input type="number" name="pedidoc2_cantidad" id="pedidoc2_cantidad"  class="form-control input-sm" required min="1">
                    </div>
                    <div class="col-sm-2">
                        <label for="pedidoc2_precio_venta" class="control-label">Precio </label>
                        <input type="text" name="pedidoc2_precio_venta" id="pedidoc2_precio_venta" class="form-control input-sm" data-currency required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-md-offset-2">
                        <div class=" col-md-1">
                            <label class="control-label">Descuento</label>
                            <input type="number" name="" class="input-sm form-control">
                        </div>

                        <div class="col-md-1"><br>
                            <label class="radio-inline without-padding" for="">
                                <input type="radio" id="" name="" value="" checked> %
                            </label>
                        </div>
                        <div class="col-md-1"><br>
                            <input type="number" name="" class="form-control input-sm">
                        </div>
                        <div class="col-md-1"><br>
                            <label class="radio-inline without-padding" for="">
                                <input type="radio" id="" name="" value="" checked> Valor
                            </label>
                        </div> 
                        <div class="col-md-1"><br>
                            <input type="number" name="" class="form-control input-sm">
                        </div>
                        <div class="col-md-1"><br>
                            <label class="radio-inline without-padding" for="">
                                <input type="radio" id="" name="" value="" checked> Final
                            </label>
                        </div> 
                        <div class="col-md-1">
                            <label class="control-label">Iva</label>
                            <input type="text" class="input-sm form-control" name="">
                        </div>
                        <div class="col-md-1"><br>
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </script>
@stop