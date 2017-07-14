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

    <section class="content" id="content-show">
        @yield ('module')
        
        <div class="modal fade" id="modal-ubicacion-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header small-box {{ config('koi.template.bg') }}">
                        <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4><strong>Ubicacion producto</strong></h4>
                    </div>
                    {!! Form::open(['id' => 'form-ubicacion-component', 'data-toggle' => 'validator']) !!}
                        <div class="modal-body">
                            <div class="content-modal"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-sm">Continuar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <script type="text/template" id="add-producto-tpl">
        <div class="row">
            <div class="form-group col-md-2">
                <label for="producto_referencia" class="control-label">Referencia</label>
                <input type="text" id="producto_referencia" name="producto_referencia" value="<%- producto_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper" maxlength="20" required>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_ref_proveedor" class="control-label">Referencia Proveedor</label>
                <input type="text" id="producto_ref_proveedor" name="producto_ref_proveedor" value="<%- producto_ref_proveedor %>" placeholder="Referencia Proveedor " class="form-control input-sm input-toupper" maxlength="20" required>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-md-8">
            <label for="producto_nombre" class="control-label">Nombre</label>
                <input type="text" id="producto_nombre" name="producto_nombre" value="<%- producto_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="100" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_unidadnegocio" class="control-label">Unidad Negocio</label>
                <select name="producto_unidadnegocio" id="producto_unidadnegocio" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\UnidadNegocio::getUnidadesNegocio() as $key => $value)
                        <option value="{{ $key }}" <%- producto_unidadnegocio == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="unidadnegocio" data-field="producto_unidadnegocio" > <i class="fa fa-plus"></i></button>
            </div>
             <div class="form-group col-md-2 col-xs-10">
                <label for="producto_linea" class="control-label">Línea</label>
                <select name="producto_linea" id="producto_linea" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Linea::getLineas() as $key => $value)
                        <option value="{{ $key }}" <%- producto_linea == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="linea" data-field="producto_linea" > <i class="fa fa-plus"></i></button>
            </div>
        </div>    
        <div class="row">
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_categoria" class="control-label">Categoría</label>
                <select name="producto_categoria" id="producto_categoria" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Categoria::getCategorias() as $key => $value)
                        <option value="{{ $key }}" <%- producto_categoria == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="categoria" data-field="producto_categoria" > <i class="fa fa-plus"></i></button>
            </div>
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_subcategoria" class="control-label">SubCategoría</label>
                <select name="producto_subcategoria" id="producto_subcategoria" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\SubCategoria::getSubCategorias() as $key => $value)
                        <option value="{{ $key }}" <%- producto_subcategoria == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="subcategoria" data-field="producto_subcategoria" > <i class="fa fa-plus"></i></button>
            </div>
           
        
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_unidadmedida" class="control-label">Unidad de medida</label>
                <select name="producto_unidadmedida" id="producto_unidadmedida" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Unidad::getUnidades() as $key => $value)
                        <option value="{{ $key }}" <%- producto_unidadmedida == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="unidadmedida" data-field="producto_unidadmedida" > <i class="fa fa-plus"></i></button>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label for="producto_peso" class="control-label">Peso (kg)</label><br>
                <input type="text" id="producto_peso" name="producto_peso" value="<%-producto_peso %>" placeholder="Peso" class="form-control input-sm spinner-percentage" min="1" required>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_largo" class="control-label">Largo (cm)</label><br>
                <input type="text" id="producto_largo" name="producto_largo" value="<%- producto_largo %>" placeholder="Largo" class="form-control input-sm spinner-percentage" min="1" required>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_alto" class="control-label">Alto (cm)</label><br>
                <input type="text" id="producto_alto" name="producto_alto" value="<%- producto_alto %>" placeholder="Alto" class="form-control input-sm spinner-percentage" min="1" required>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_ancho" class="control-label">Ancho (cm)</label><br>
                <input type="text" id="producto_ancho" name="producto_ancho" value="<%- producto_ancho %>" placeholder="Ancho" class="form-control input-sm spinner-percentage" min="1" required>
            </div>
        </div>
        <div class="row">
            
            <div class="form-group col-md-2 col-xs-6">
                <label for="producto_maneja_serie" class="control-label">¿Maneja serie?</label>
                <div><input type="checkbox" id="producto_maneja_serie" name="producto_maneja_serie" value="producto_maneja_serie" <%- parseInt(producto_maneja_serie) ? 'checked': ''%>></div>
            </div>

            <div class="form-group col-md-2 col-xs-6">
                <label for="producto_metrado" class="control-label">¿Producto metrado?</label>
                <div><input type="checkbox" id="producto_metrado" name="producto_metrado" value="producto_metrado" <%- parseInt(producto_metrado) ? 'checked': ''%>></div>
            </div>
            <div class="form-group col-md-2 col-xs-6">
                <label for="producto_vence" class="control-label">¿Producto vence?</label>
                <div><input type="checkbox" id="producto_vence" name="producto_vence" value="producto_vence" <%- parseInt(producto_vence) ? 'checked': ''%>></div>
            </div>
            <div class="form-group col-md-2 col-xs-6">
                <label for="producto_unidad" class="control-label">¿Controla inventario?</label>
                <div><input type="checkbox" id="producto_unidad" name="producto_unidad" value="producto_unidad" <%- parseInt(producto_unidad) ? 'checked': ''%>></div>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_marca" class="control-label">Marca</label>
                <select name="producto_marca" id="producto_marca" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Marca::getMarcas() as $key => $value)
                        <option value="{{ $key }}" <%- producto_marca == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="marca" data-field="producto_marca" > <i class="fa fa-plus"></i></button>
            </div>
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_modelo" class="control-label">Modelo</label>
                <select name="producto_modelo" id="producto_modelo" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Modelo::getModelos() as $key => $value)
                        <option value="{{ $key }}" <%- producto_modelo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>  
            <div class="form-group col-md-1">
                <br>
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="modelo" data-field="producto_modelo" > <i class="fa fa-plus"></i></button>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_barras" class="control-label">Código De Barras</label>
                <input type="text" id="producto_barras" name="producto_barras" value="<%- producto_barras %>" placeholder="Código De Barras" class="form-control input-sm input-toupper" maxlength="100" required>
            </div>    
        </div>

        <div class="row">
            <div class="form-group col-md-2">
                <label for="producto_precio1" class="control-label">Precio Mínimo</label>
                <input type="text" id="producto_precio1" name="producto_precio1" value="$  <%- producto_precio1 %>" class="form-control input-sm" maxlength="15" data-currency-precise required>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_precio2" class="control-label">Precio Sugerido</label>
                <input type="text" id="producto_precio2" name="producto_precio2" value="<%- producto_precio2 %>" class="form-control input-sm" maxlength="15" data-currency-precise required>
            </div>
            <div class="form-group col-md-2">
                <label for="producto_precio3" class="control-label">Precio Crédito</label>
                <input type="text" id="producto_precio3" name="producto_precio3" value="<%- producto_precio3 %>" class="form-control input-sm" maxlength="15" data-currency-precise required>
            </div>
            <div class="form-group col-md-2 col-xs-10">
                <label for="producto_impuesto" class="control-label">Impuesto</label>
                <select name="producto_impuesto" id="producto_impuesto" class="form-control select2-default-clear" required>
                    @foreach( App\Models\Inventario\Impuesto::getImpuestos() as $key => $value)
                        <option value="{{ $key }}" <%- producto_impuesto == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-seriesprodbode-tpl">
        <table id="prodbod-search-table" class="table table-striped">
            <tbody>
                <tr>
                    <th>Serie</th>
                    <th colspan="2">Nombre</th>
                    <th>Sucursal</th>
                </tr>

                <% if( series == '') { %>
                    <tr>
                        <th colspan="4" class="text-center">NO EXISTEN SERIES ASOCIADAS</th>
                    </tr>
                <% } %>

                <% _.each(series, function(serie) { %>
                    <tr>
                        <td><%- serie.producto_serie %></td>
                        <td colspan="2"><%- serie.producto_nombre %></td>
                        <td><%- serie.sucursal_nombre %></td>
                    </tr>
                <% }); %>
            </tbody>
    </script>

    <script type="text/template" id="add-ubicacion-tpl">
        <div class="row">
            <div class="col-md-3">
                <label for="prodbode_serie" class="control-label">Serie</label>
            </div>
            <div class="col-md-7">
                <%- serie %>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="modal-nombre" class="control-label">Nombre</label>
            </div>
            <div class="col-md-7">
                <%- nombre %>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="prodbode_sucursal" class="control-label">Sucursal</label>
            </div>
            <div class="col-md-7">
                <%- sucursal %>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="prodbode_ubicacion1" class="control-label">Ubicacion</label>
            </div>
            <div class="form-group col-md-7">
                <input type="text" id="prodbode_ubicacion1" data-id="<%- id %>" name="prodbode_ubicacion1" class="form-control input-sm" required>
            </div>
        </div>
    </script>
@stop