@extends('layout.layout')

@section('title') Traslados de ubicación @stop

@section('content')
    <section class="content-header">
        <h1>
            Traslados de ubicación <small>Administración de trasladosubicaciones de ubicación</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-trasladoubicacion-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-trasladoubicacion" data-toggle="validator">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="trasladou1_sucursal" class="control-label">Sucursal</label>
                    <select name="trasladou1_sucursal" id="trasladou1_sucursal" class="changed-koi-sucursal-repeat  form-control select2-default-clear change-sucursal-consecutive-koi-component" data-wrapper="trasladosubicaciones-create" data-field="trasladou1_numero" data-document="trasladosubicaciones" required>
                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option value="{{ $key }}" <%- trasladou1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label for="trasladou1_numero" class="control-label">Número</label>
                    <input id="trasladou1_numero" name="trasladou1_numero" placeholder="Número" class="form-control input-sm input-toupper" type="number" required readonly>
                </div>

                <div class="form-group col-sm-2">
                    <label for="trasladou1_fecha" class="control-label">Fecha</label>
                    <input type="text" id="trasladou1_fecha" name="trasladou1_fecha" placeholder="Fecha" value="<%- trasladou1_fecha %>" class="form-control input-sm datepicker" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="trasladou1_origen" class="control-label">Ubicación origen</label>
                    <select name="trasladou1_origen" id="trasladou1_origen" class="form-control select2-default-clear" required></select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="trasladou1_destino" class="control-label">Ubicación destino</label>
                    <select name="trasladou1_destino" id="trasladou1_destino" class="form-control select2-default-clear" required></select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="trasladou1_tipotraslado" class="control-label">Tipo</label>
                      <select name="trasladou1_tipotraslado" id="trasladou1_tipotraslado" class="form-control select2-default-clear" required>
                        @foreach( App\Models\Inventario\TipoTraslado::getTiposTraslados() as $key => $value)
                            <option value="{{ $key }}" <%- trasladou1_tipotraslado == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>  
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="trasladou1_observaciones" class="control-label">Observaciones</label>
                    <textarea id="trasladou1_observaciones" name="trasladou1_observaciones" class="form-control" rows="2" placeholder="Observaciones"><%- trasladou1_observaciones %></textarea>
                </div>
            </div>
        </form>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                    <a href="<%- window.Misc.urlFull( Route.route('trasladosubicaciones.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2 col-sm-5 col-xs-6">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-trasladoubicacion">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>
        <!-- Detalle -->
        <div class="box box-solid">
            <form method="POST" accept-charset="UTF-8" id="form-item-trasladoubicacion" data-toggle="validator">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-sm-2 col-md-offset-1">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="producto_serie">
                                        <i class="fa fa-barcode"></i>
                                    </button>
                                </span>
                                <input id="producto_serie" placeholder="Producto" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="trasladosubicaciones-create" data-name="producto_nombre" data-ref = "false" data-costo="ajuste2_costo" data-office="trasladou1_sucursal" required>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                            <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                        </div>

                        <label for="trasladou2_cantidad" class="col-sm-1 control-label">Unidades</label>
                        <div class="form-group col-sm-1">
                            <input id="trasladou2_cantidad" name="trasladou2_cantidad" class="form-control" min="1" type="number" required>
                        </div>
                        <div class="form-group col-sm-1">
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- table table-bordered table-striped -->
            <div class="box-body table-responsive no-padding">
                <table id="browse-detalle-trasladou-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Unidades</th>
                    </tr>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <th class="text-left">Total</th>
                            <td class="text-right" id="total-costo">0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-trasladou2-item-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-trasladou2-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>
        <td><%- trasladou2_cantidad %></td>
    </script>
@stop