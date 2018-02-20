@extends('layout.layout')

@section('title') Productos @stop

@section('content')
    <section class="content-header">
        <h1>
            Productos <small>Administración de productos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-producto-tpl">
        <div class="row">
            <label for="producto_referencia" class="control-label col-md-1 col-sm-2">Referencia</label>
            <div class="form-group col-md-3 col-sm-10">
                <input type="text" id="producto_referencia" name="producto_referencia" value="<%- producto_referencia %>" placeholder="Referencia producto" class="form-control input-sm input-toupper change-referencia-koi-component" maxlength="20" required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="producto_ref_proveedor" class="control-label col-md-1 col-sm-2">Proveedor</label>
            <div class="form-group col-md-3 col-sm-10">
                <input type="text" id="producto_ref_proveedor" name="producto_ref_proveedor" value="<%- producto_ref_proveedor %>" placeholder="Referencia Proveedor " class="form-control input-sm input-toupper" maxlength="20" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>

        <div class="row">
            <label for="producto_nombre" class="control-label col-md-1 col-sm-2">Nombre</label>
            <div class="form-group col-md-8 col-sm-10">
                <input type="text" id="producto_nombre" name="producto_nombre" value="<%- producto_nombre %>" placeholder="Nombre producto" class="form-control input-sm input-toupper" maxlength="100" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>

        <div class="row">
            <label for="producto_grupo" class="control-label col-md-1 col-sm-2">Grupo</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_grupo" id="producto_grupo" class="form-control select2-default-clear" data-field="producto_grupo" required>
                    @foreach( App\Models\Inventario\Grupo::getGrupos() as $key => $value)
                        <option value="{{ $key }}" <%- producto_grupo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-1 col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="grupo" data-field="producto_grupo">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <label for="producto_subgrupo" class="control-label col-md-1 col-sm-2">Subgrupo</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_subgrupo" id="producto_subgrupo" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\SubGrupo::getSubGrupos() as $key => $value)
                        <option value="{{ $key }}" <%- producto_subgrupo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-1 col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="subgrupo" data-field="producto_subgrupo">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="row">
            <label for="producto_linea" class="control-label col-md-1 col-sm-2">Línea</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_linea" id="producto_linea" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Linea::getLineas() as $key => $value)
                        <option value="{{ $key }}" <%- producto_linea == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-1 col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="linea" data-field="producto_linea" >
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <label for="producto_tipoproducto" class="control-label col-md-1 col-sm-2">Tipo de producto</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_tipoproducto" id="producto_tipoproducto" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\TipoProducto::getTiposProducto() as $key => $value)
                        <option value="{{ $key }}" <%- producto_tipoproducto == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-1 col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tipoproducto" data-field="producto_tipoproducto">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <label for="producto_unidadmedida" class="control-label col-md-1 col-sm-2">Und medida</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_unidadmedida" id="producto_unidadmedida" class="form-control select2-default-clear">
                    @foreach( App\Models\Inventario\Unidad::getUnidades() as $key => $value)
                        <option value="{{ $key }}" <%- producto_unidadmedida == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-1 col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="unidadmedida" data-field="producto_unidadmedida" > <i class="fa fa-plus"></i></button>
            </div>
            <label for="producto_impuesto" class="control-label col-md-1 col-sm-2">Impuesto</label>
            <div class="form-group col-md-4 col-sm-10 col-xs-10">
                <select name="producto_impuesto" id="producto_impuesto" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Impuesto::getImpuestos() as $key => $value)
                        <option value="{{ $key }}" <%- producto_impuesto == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="producto_marca" class="control-label col-md-1 col-sm-2">Marca</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_marca" id="producto_marca" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Marca::getMarcas() as $key => $value)
                        <option value="{{ $key }}" <%- producto_marca == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-1 col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="marca" data-field="producto_marca">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <label for="producto_modelo" class="control-label col-md-1 col-sm-2">Modelo</label>
            <div class="form-group col-md-4 col-sm-8 col-xs-10">
                <select name="producto_modelo" id="producto_modelo" class="form-control select2-default-clear" required <%- producto_modelo ? '' : 'disabled'%>>
                    <option value="<%- producto_modelo %>"><%- typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '' ? modelo_nombre : '' %></option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <label for="producto_maneja_serie" class="control-label">¿Maneja serie?
                    <input type="checkbox" id="producto_maneja_serie" name="producto_maneja_serie" value="producto_maneja_serie" <%- parseInt(producto_maneja_serie) ? 'checked': ''%>>
                </label>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <label for="producto_metrado" class="control-label">¿Producto metrado?
                    <input type="checkbox" id="producto_metrado" name="producto_metrado" value="producto_metrado" <%- parseInt(producto_metrado) ? 'checked': ''%>>
                </label>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3  col-sm-6 col-xs-12">
                <label for="producto_vence" class="control-label">¿Producto vence?
                    <input type="checkbox" id="producto_vence" name="producto_vence" value="producto_vence" <%- parseInt(producto_vence) ? 'checked': ''%>>
                </label>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <label class="control-label" for="producto_unidad">¿En inventario?
                    <input type="checkbox" id="producto_unidad" name="producto_unidad" value="producto_unidad" <%- parseInt(producto_unidad) ? 'checked': ''%>>
                </label>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="producto_peso" class="control-label col-md-1 col-sm-2">Peso (kg)</label>
            <div class="form-group col-md-2 col-sm-4">
                <input type="text" id="producto_peso" name="producto_peso" value="<%-producto_peso %>" placeholder="Peso" class="form-control input-sm spinner-percentage" min="1" required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="producto_largo" class="control-label col-md-1 col-sm-2">Largo (cm)</label>
            <div class="form-group col-md-2 col-sm-4">
                <input type="text" id="producto_largo" name="producto_largo" value="<%- producto_largo %>" placeholder="Largo" class="form-control input-sm spinner-percentage" min="1" required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="producto_alto" class="control-label col-md-1 col-sm-2">Alto (cm)</label>
            <div class="form-group col-md-2 col-sm-4">
                <input type="text" id="producto_alto" name="producto_alto" value="<%- producto_alto %>" placeholder="Alto" class="form-control input-sm spinner-percentage" min="1" required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="producto_ancho" class="control-label col-md-1 col-sm-2">Ancho (cm)</label>
            <div class="form-group col-md-2 col-sm-4">
                <input type="text" id="producto_ancho" name="producto_ancho" value="<%- producto_ancho %>" placeholder="Ancho" class="form-control input-sm spinner-percentage" min="1" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>

        <div class="row">
            <label for="producto_precio1" class="control-label col-md-1 col-sm-2">$ Mínimo</label>
            <div class="form-group col-md-2 col-sm-10">
                <input type="text" id="producto_precio1" name="producto_precio1" value="$  <%- producto_precio1 %>" class="form-control input-sm" maxlength="15" data-currency-precise required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="producto_precio2" class="control-label col-md-1 col-sm-2">$ Sugerido</label>
            <div class="form-group col-md-2 col-sm-10">
                <input type="text" id="producto_precio2" name="producto_precio2" value="<%- producto_precio2 %>" class="form-control input-sm" maxlength="15" data-currency-precise required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="producto_precio3" class="control-label col-md-1 col-sm-2">$ Crédito</label>
            <div class="form-group col-md-2 col-sm-10">
                <input type="text" id="producto_precio3" name="producto_precio3" value="<%- producto_precio3 %>" class="form-control input-sm" maxlength="15" data-currency-precise required>
                <div class="help-block with-errors"></div>
            </div>

        </div>
    </script>

    <script type="text/template" id="add-seriesprodbode-tpl">
        <% if (producto_maneja_serie == 1){ %>
            <td><%- sucursal_nombre %></td>
            <td><%- producto_serie %></td>
            <td><%- producto_nombre %></td>
            <td><%- ubicacion_nombre %></td>
        <% }else if(producto_vence == 1){ %>
            <td><%- sucursal_nombre %></td>
            <td><%- ubicacion_nombre %></td>
            <td><%- lote_saldo %></td>
            <td><%- lote_vencimiento %></td>
        <% }else if(producto_metrado == 1){ %>
            <td><%- sucursal_nombre %></td>
            <td><%- rollo_rollos %> X <%- rollo_saldo %> (Mts)</td>
            <td><%- ubicacion_nombre %></td>
        <% }else{ %>
            <td><%- sucursal_nombre %></td>
            <td><%- ubicacion_nombre %></td>
            <td><%- prodbode_cantidad %></td>
        <% } %>
    </script>
@stop
