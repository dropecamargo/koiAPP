@extends('layout.layout')
@section('title') Configuración sabana de venta @stop
@section('content')
   	<section class="content-header">
        <h1>
            Configuración sabana de venta
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
          	<li>Config sabana de venta</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary" id="configsabanaventa-create">
            <div class="box-body table-responsive">
                <table id="configsabanaventa-search-table" class="table table-condensed" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td colspan="2">
                                La configuración de la sabana de ventas se basa en cuatro niveles: Agrupación ->>> Grupo ->> Unificación -> Linea de Negocio. Los grupo contienen las unificaciones que reunen una o mas lineas de negocio bajo un solo nombre y el cual es totalizado en conjunto incluyendo las lineas de negocio escogidas; la agrupación reune uno o mas grupos bajo un solo nombre que reune una o mas unificaciones bajo un solo nombre totalizando la agrupacion en conjunto incluyendo los grupos y las unificaciones escogidas.
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">
                                <a class="btn btn-success btn-xs add-item" data-call="add-agrupation">
                                    <span><i class="fa fa-plus"></i></span>
                                </a>
                            </th>
                            <th>Agrupación</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>

    <script type="text/template" id="browse-detailconfigsabanaventa-tpl">
        <table class="table table-condensed" id="table-detailconfigsabanaventa" width="100%">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="25%">&nbsp; &nbsp; Grupo
                        <a class="btn btn-success btn-xs pull-left add-item" data-call="add-group" data-resource= "<%- agrupacion %>" >
                            <span><i class="fa fa-plus"></i></span>
                        </a>
                    </th>
                    <th width="25%">&nbsp; &nbsp; Unificación
                        <a class="btn btn-success btn-xs pull-left add-item" data-call="add-unification" data-resource= "<%- agrupacion %>" >
                            <span><i class="fa fa-plus"></i></span>
                        </a>
                    </th>
                    <th width="40%">&nbsp; &nbsp; Línea
                        <a class="btn btn-success btn-xs pull-left add-item" data-call="add-line" data-resource="<%- agrupacion %>" >
                            <span><i class="fa fa-plus"></i></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <% var unificacion = grupo = '' %>
                <% _.each( data, function( item ){ %>
                    <% if (grupo != item.configsabanaventa_grupo){ %>
                        <tr>
                            <td></td>
                            <td colspan="2"><%- item.configsabanaventa_grupo_nombre %></td>
                        </tr>
                        <% } %>
                    <% if (unificacion != item.configsabanaventa_unificacion){ %>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2"><%- item.configsabanaventa_unificacion_nombre %></td>
                        </tr>
                    <% } %>
                    <tr id=remove-line<%- item.id %>>
                        <td colspan="3"></td>
                        <td>
                            <a class="btn btn-default btn-xs pull-left remove-item" data-call="remove-line" data-name="<%- item.linea_nombre %>" data-resource="<%- item.id %>">
                                <span><i class="fa fa-times"></i></span>
                            </a> &nbsp; &nbsp; <%- item.linea_nombre %>
                        </td>
                    </tr>
                    <%
                        unificacion = item.configsabanaventa_unificacion;
                        grupo = item.configsabanaventa_grupo;
                    %>
                <% }); %>
            </tbody>
        </table>
    </script>
    <script type="text/template" id="configsabana-remove-confirm-tpl">
        <p>¿Está seguro que desea eliminar la línea de nombre <b><%- line %> </b> de la configuración de sabana de ventas?</p>
    </script>
    <script type="text/template" id="configsabana-modal-store-tpl">
            <div class="row">
                <label for="configsabanaventa_agrupacion_nombre" class="col-md-2 control-label">Agrupación</label>
                <div class="form-group col-md-10">
                    <% if(call === 'add-agrupation'){%>
                        <input id="configsabanaventa_agrupacion_nombre" name="configsabanaventa_agrupacion_nombre" placeholder="Nombre agrupación"class="form-control input-sm input-toupper" type="text" maxlength="50" required>
                    <% }else{ %>
                        <select name="configsabanaventa_agrupacion" id="configsabanaventa_agrupacion" class="form-control select2-default-clear" required disabled>
                            @foreach( App\Models\Comercial\ConfigSabanaVenta::getAgrupaciones() as $key => $value)
                                <option value="{{ $key }}" <%- agrupacion == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    <% } %>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        <div class="row">
            <label for="configsabanaventa_grupo_nombre" class="col-md-2 control-label">Grupo</label>
            <div class="form-group col-md-10">
                <% if(call === 'add-group' || call === 'add-agrupation'){ %>
                    <input id="configsabanaventa_grupo_nombre" name="configsabanaventa_grupo_nombre" placeholder="Nombre grupo"class="form-control input-sm input-toupper" type="text" maxlength="50" required>
                <% }else{ %>
                    <select name="configsabanaventa_grupo" id="configsabanaventa_grupo" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('configsabana.grupos', {configsabana: agrupacion }))%>" data-placeholder="Seleccione">
    				</select>
                <% } %>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="configsabanaventa_unificacion_nombre" class="col-md-2 control-label">Unificación</label>
            <div class="form-group col-md-10">
                <% if(call === 'add-line'){ %>
                    <select name="configsabanaventa_unificacion" id="configsabanaventa_unificacion" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('configsabana.unificaciones', {configsabana: agrupacion }))%>" data-placeholder="Seleccione">
    				</select>
                <% }else { %>
                    <input id="configsabanaventa_unificacion_nombre" name="configsabanaventa_unificacion_nombre" placeholder="Nombre unificación"class="form-control input-sm input-toupper" type="text" maxlength="50" required>
                <% }%>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="configsabanaventa_linea" class="col-md-2 control-label">Línea</label>
            <div class="form-group col-md-10">
                <select name="configsabanaventa_linea" id="configsabanaventa_linea" class="form-control select2-default-clear" required>
                    <option value=""></option>
                    @foreach( App\Models\Comercial\ConfigSabanaVenta::getLines() as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->linea_nombre }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </script>
@stop
