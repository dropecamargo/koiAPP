@extends('layout.layout')

@section('title') Devoluciones @stop

@section('content')
    <section class="content-header">
        <h1>
            Devoluciones <small>Administración de devoluciones </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-devoluciones-tpl" >
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-devolucion1" data-toggle="validator">
                <div class="row">
                    <label for="devolucion1_sucursal" class="col-sm-1 col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-3">
                        <select name="devolucion1_sucursal" id="devolucion1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-wrapper="devolucion-create" data-field="devolucion1_numero" data-document ="devolucion">
                            @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- devolucion1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="devolucion1_numero" class="col-sm-1 col-md-1 control-label">Número</label>
                    <div class="form-group col-sm-1 col-md-1">
                        <input id="devolucion1_numero" name="devolucion1_numero" class="form-control input-sm" type="number" min="1" value="<%- devolucion1_numero %>" required readonly>
                    </div>
                    <label for="devolucion1_fecha" class="col-sm-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input id="devolucion1_fecha" name="devolucion1_fecha" class="form-control input-sm datepicker-back" type="text" value="{{ date('Y-m-d')}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="devolucion_factura1" class="col-sm-1 control-label">N° factura</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-factura-component" data-field="devolucion1_factura1">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                             <input id="devolucion1_factura1" placeholder="Número factura" class="form-control factura-koi-component" name="devolucion1_factura1" type="text" maxlength="15" required data-sucursal="devolucion1_sucursal" data-name="devolucion1_nombre_tercero" data-nit="devolucion1_tercero" data-devueltas="false" data-wrapper="factura-create">
                        </div>
                    </div>
                    <label for="devolucion1_tercero" class="col-sm-1 control-label">Cliente</label>
                    <div class="form-group col-sm-2">
                        <input type="text" name="devolucion1_tercero" id="devolucion1_tercero" class="input-sm form-control" required placeholder="Cliente" readonly>
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="text" name="devolucion1_nombre_tercero" id="devolucion1_nombre_tercero" class="input-sm form-control" required placeholder="Nombre cliente" readonly>
                    </div>
                </div>
                <div class="row">
                    <label for="devolucion1_observacion" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-sm-11">
                    <textarea id="devolucion1_observacion" name="devolucion1_observacion" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                </div><br>

                <div class="box box-body box-primary">
                    <div class="table-responsive no-padding">
                        <table id="browse-detalle-devolucion-list" class="table table-hover table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="6" class="text-center">
                                        <button type="button" class="btn btn-default btn-sm all-devoluciones">Devolver todas</button>
                                    </th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th width="15%">Referencia</th>
                                    <th width="40%">Nombre</th>
                                    <th width="5%">Cantidad</th>
                                    <th width="15%">Precio</th>
                                    <th width="10%">Devueltas</th>
                                    <th width="15%">Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--Render content detalle--}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th id="total_devueltas"> </th>
                                    <th id="total"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('devoluciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-devolucion">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-devoluciones-item-tpl">
        <!-- <td></td> -->
        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>

        <% if(edit){ %>
            <td><%- factura2_cantidad %></td>
        <% }else{ %>
            <td><%- devolucion2_cantidad %></td>
        <% } %>

        <td><%- window.Misc.currency(devolucion2_costo) %></td>

        <% if(edit){ %>
            <td>
                <input type="number" name="devolucion2_cantidad_<%- id %>" id="devolucion2_cantidad_<%- id %>" max="<%- factura2_cantidad %>" min="0" class="form-control input-sm change-cant-devo" value="<%-devolucion2_cantidad %>" step="1">
            </td>
        <% } %>

        <td id="total_<%- id %>"><%- window.Misc.currency(devolucion2_total) %></td>
    </script>
@stop
