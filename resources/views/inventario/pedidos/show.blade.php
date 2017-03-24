@extends('inventario.pedidos.main')

@section('breadcrumb')
	<li><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
	<li class="active">{{ $pedido1->id }}-{{ $pedido1->pedido1_numero }}</li>
@stop

@section('module')

	<div class="box box-whithout-border" id="pedido-show">
		<div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_pedido" data-toggle="tab">Pedido</a></li>
               
                    <li><a href="#tab_bitacora" data-toggle="tab">Bitácora</a></li>
                    
                    @if(!$pedido1->pedido1_anulado)
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                               
                                <a role="menuitem" tabindex="-1" href="#" class="cancel-pedido">
                                    <i class="fa fa-times"></i>Anular Pedido
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
            </ul><br>
            <div class="tab-content">
                {{-- Content pedido --}}
                <div class="tab-pane active" id="tab_pedido">
                    <div class="box box-whithout-border">
                        <div id="render-pedido-show" class="box-body">{{--Render-show--}}</div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                                <a href="{{ route('pedidos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a><br>
                            </div>   
                        </div>
                    </div>
                </div>
                {{-- Content bitacora --}}    
                <div class="tab-pane" id="tab_bitacora">
                    <div class="box box-whithout-border" id="wrapper-bitacora">
                        <div class="box-body">
                            <div class="table-responsive no-padding">
                       
                                <table id="browse-bitacora-list" class="table table-hover table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="20%">Nombre</th>
                                            <th width="20%">Campo</th>
                                            <th width="20%">Anterior</th>
                                            <th width="20%">Nuevo</th>
                                            <th width="20%">Fecha</th>
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
            </div>      
        </div>
	</div>
    <script type="text/template" id="show-pedido-tpl">
        
        <div class="row">
            <label for="pedido1_sucursal" class="col-sm-1 control-label">Sucursal</label>
            <div class="form-group col-sm-2">
               <div><%-sucursal_nombre %></div>
            </div>
            <label for="pedido1_numero" class="col-sm-1 control-label">Número</label>
            <div class="form-group col-sm-1">     
                <%- pedido1_numero %>
            </div>
        </div>
        <div class="row">
            <label for="pedido1_fecha" class="col-sm-1  control-label">Fecha</label>
            <div class="form-group col-sm-2 ">
                <%- pedido1_fecha %>
            </div> 
            <label for="pedido1_fecha_estimada" class="col-sm-2 control-label">Fecha Estimada De Llegada</label>
            <div class="form-group col-sm-2 ">
                <%-pedido1_fecha_estimada %>
            </div> 
        </div>
             
        <div class="row">
            <label for="pedido1_fecha_anticipo" class="col-sm-1  control-label">Fecha Anticipo</label>
            <div class="form-group col-sm-2">
                <%-pedido1_fecha_anticipo%>
            </div> 
            <label for="pedido1_anticipo" class="col-sm-2 control-label">Valor Antcipo</label>
            <div class="form-group col-sm-2 ">
                <%- window.Misc.currency(pedido1_anticipo) %>
            </div> 
        </div>

        <div class="row">
            <label for="pedido1_tercero" class="col-sm-1  control-label">Cliente</label>
            <div class="form-group col-sm-10">
                <div class="input-group input-group-sm">
                  <%-tercero_nit %> - <%-tercero_nombre %>
                </div>
            </div>             
        </div> 

        <div class="row">
            <label for="pedido1_observaciones" class="col-sm-1 control-label">Observaciones</label>
            <div class="form-group col-md-10">
                <%- pedido1_observaciones %>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-body">
                <div class="table-responsive no-padding">
                    <table id="browse-detalle-pedido-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Referencia</th>
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
    </script>
    <script type="text/template" id="pedido-cancel-confirm-tpl">
        <p>¿Está seguro que desea anular el pedido de mercancía <b><%- id_pedido %></b>?</p>
    </script>
@stop