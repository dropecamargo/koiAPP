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
            <div class="box-body table-responsive table-condensed">
                <table id="configsabanaventa-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td colspan="5">
                                La configuración de la sabana de ventas se basa en cuatro niveles: Agrupación ->>> Grupo ->> Unificación -> Linea de Negocio. Los grupo contienen las unificaciones que reunen una o mas lineas de negocio bajo un solo nombre y el cual es totalizado en conjunto incluyendo las lineas de negocio escogidas; la agrupación reune uno o mas grupos bajo un solo nombre que reune una o mas unificaciones bajo un solo nombre totalizando la agrupacion en conjunto incluyendo los grupos y las unificaciones escogidas.
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">
                                <a class="btn btn-success btn-xs">
                                    <span><i class="fa fa-plus"></i></span>
                                </a>
                            </th>
                            <th>Agrupación</th>
                            <th>Unificación</th>
                            <th>Grupo</th>
                            <th>Línea</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <script type="text/template" id="browse-detailconfigsabanaventa-tpl">
        <table class="table table-condensed" width="100%">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="25%">&nbsp; &nbsp; Grupo
                        <a class="btn btn-success btn-xs pull-left">
                            <span><i class="fa fa-plus"></i></span>
                        </a>
                    </th>
                    <th width="25%">&nbsp; &nbsp; Unificación
                        <a class="btn btn-success btn-xs pull-left">
                            <span><i class="fa fa-plus"></i></span>
                        </a>
                    </th>
                    <th width="40%">&nbsp; &nbsp; Línea
                        <a class="btn btn-success btn-xs pull-left">
                            <span><i class="fa fa-plus"></i></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <% var unificacion = grupo = '' %>
                <% _.each(resp, function( item ){ %>
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
                    <tr>
                        <td colspan="3"></td>
                        <td>
                            <a class="btn btn-default btn-xs">
                                <span><i class="fa fa-times"></i></span>
                            </a>   <%- item.linea_nombre %>
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


@stop
