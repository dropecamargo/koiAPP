@extends('layout.layout')

@section('title') Ordenes @stop

@section('content')
<section class="content-header">
    <h1>
        Orden<small>Administración de Ordenes</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i>{{ trans('app.home') }}</a></li>
        @yield('breadcrumb')
    </ol>
</section>

<section class="content" id="orden-content-section">
    @yield ('module')
    <!-- Modal info visita-->
    <div class="modal fade" id="modal-visita-show-info-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header small-box {{ config('koi.template.bg') }}">
                    <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><strong>Detalle visita</strong></h4>
                </div>
                <div class="modal-body" id="modal-visita-wrapper-show-info">
                    <div class="content-modal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal info remision -->
    <div class="modal fade" id="modal-remision-show-info-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header small-box {{ config('koi.template.bg') }}">
                    <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><strong>Detalle remisión</strong></h4>
                </div>
                <div class="modal-body" id="modal-remision-wrapper-show-info">
                    <div class="content-modal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal info remision -->
    <div class="modal fade" id="modal-create-remision" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header small-box {{ config('koi.template.bg') }}">
                    <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><strong>Tecnico - Nueva remisión</strong></h4>
                </div>
                {!! Form::open(['id' => 'form-remrepu', 'data-toggle' => 'validator']) !!}
                    <div class="modal-body" id="modal-remision-wrapper-show-info">
                        <div class="content-modal">
                        </div>
                    </div>
                {!! Form::close() !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm click-store-remsion">Continuar</button>
                    </div>
            </div>
        </div>
    </div>
</section>

<script type="text/template" id="add-orden-tpl">
    <div class="row">
        <div class="form-group col-md-12">
            <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_orden" data-toggle="tab">Orden</a></li>
                    <% if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                        <li><a href="#tab_visitas" data-toggle="tab">Visitas</a></li>
                        <li><a href="#tab_remisiones" data-toggle="tab">Remisiones</a></li>
                        <li><a href="#tab_imagenes" data-toggle="tab">Imagenes</a></li>
                        <li><a href="#tab_cierre" data-toggle="tab">Cierre</a></li>
                    <% } %>
                </ul>
                <div class="tab-content">
                    {{-- Content orden --}}
                    <div class="tab-pane active" id="tab_orden">
                        <div class="box box-whithout-border">
                            <div class="box-body">
                                <% if( typeof(id) != 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label">Número</label>
                                            <div><%- sucursal_nombre %></div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">Número</label>
                                            <div><%- orden_numero %></div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">F.Servcio</label>
                                            <div><%- orden_fecha_servicio %></div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">H.Servcio</label>
                                            <div><%- orden_hora_servicio %></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Tercero</label>
                                            <div>
                                                Documento: <%- tercero_nit %>
                                                <br>
                                                Nombre: <%- tercero_nombre %>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Producto</label>
                                            <div>
                                                Serie: <%- producto_serie %>
                                                <br>
                                                Nombre: <%- producto_nombre %>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Tecnico</label>
                                            <div>
                                                Documento: <%- tecnico_nit %>
                                                <br>
                                                Nombre: <%- tecnico_nombre %>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Daño</label>
                                            <div> <%- dano_nombre %> </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Solicitante</label>
                                            <div> <%- solicitante_nombre %> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Tipo</label>
                                            <div> <%- tipoorden_nombre %> </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Prioridad</label>
                                            <div> <%- prioridad_nombre %> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label"> Problema </label>
                                            <div> <%- orden_problema %> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label"> Persona </label>
                                            <div> <%- orden_llamo %> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                                            <a href=" {{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                                        </div>
                                    </div>      
                                <% }else{ %> 
                                    <form method="POST" accept-charset="UTF-8" id="form-orden" data-toggle="validator">
                                        <div class="row">
                                            <label for="orden_sucursal" class="col-sm-1 col-md-1 control-label">Sucursal</label>
                                            <div class="form-group col-sm-3">
                                                <select name="orden_sucursal" id="orden_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-field="orden_numero" data-wrapper="tab_orden" data-document ="orden">
                                                    @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                                    <option  value="{{ $key }}" <%- orden_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label for="orden_numero" class="col-sm-1 col-md-1 control-label">Número</label>
                                            <div class="form-group col-sm-1 col-md-1">     
                                                <input id="orden_numero" name="orden_numero" class="form-control input-sm" type="number" min="1" value="<%- orden_numero %>" required readonly>
                                            </div>
                                            <label for="orden_fecha_servicio" class="col-md-1 control-label">F. Servicio</label>
                                            <div class="form-group col-md-1">
                                                <input type="text" id="orden_fecha_servicio" name="orden_fecha_servicio" class="form-control input-sm datepicker" value="<%- orden_fecha_servicio %>" required>
                                            </div> 
                                            <label for="orden_hora_servicio" class="col-md-1 control-label">H. Servicio</label>
                                            <div class="form-group col-md-1">
                                                <div class="bootstrap-timepicker">
                                                    <div class="input-group">
                                                        <input type="text" id="orden_hora_servicio" name="orden_hora_servicio" placeholder="Fecha servicio" class="form-control input-sm timepicker" value="<%- orden_hora_servicio %>" required>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">  
                                            <label for="orden_tercero" class="col-md-1 control-label">Cliente</label>
                                            <div class="form-group col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="orden_tercero">
                                                            <i class="fa fa-user"></i>
                                                        </button>
                                                    </span>
                                                    <input id="orden_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="orden_tercero" type="text" maxlength="15" data-wrapper="ordenes-create" data-name="tercero_nombre" data-contacto="btn-add-contact" data-activo="true" value="<%- tercero_nit %>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-10">
                                                <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                                            </div>
                                        </div>

                                        {{--producto--}}
                                        <div class="row">
                                            <label for="orden_fecha" class="col-md-1 control-label">Producto</label>
                                            <div class="form-group col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="orden_serie" >
                                                            <i class="fa fa-barcode"></i>
                                                        </button>
                                                    </span>
                                                    <input id="orden_serie" placeholder="Serie" class="form-control producto-koi-component" name="orden_serie" type="text" maxlength="15" data-wrapper="producto_create" data-tercero="true" data-name="orden_nombre_producto" value="<%- producto_serie %>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-10">
                                                <input id="orden_nombre_producto" name="orden_nombre_producto" placeholder="Nombre producto" class="form-control input-sm" type="text" value="<%- producto_nombre %>" readonly required>
                                            </div>
                                        </div>
                                        {{--tecnico--}}
                                        <div class="row">
                                            <label for="orden_tecnico" class="col-md-1 control-label">Tecnico</label>
                                            <div class="form-group col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="orden_tecnico">
                                                            <i class="fa fa-user"></i>
                                                        </button>
                                                    </span>
                                                    <input id="orden_tecnico" placeholder="Tecnico" class="form-control tercero-koi-component" name="orden_tecnico" type="text" maxlength="15" data-wrapper="ordenes-create" data-type="tecnico" data-name="orden_tecnico_nombre" data-contacto="btn-add-contact" value="<%- tecnico_nit %>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-10">
                                                <input id="orden_tecnico_nombre" name="orden_tecnico_nombre" placeholder="Nombre Tecnico" class="form-control input-sm" type="text" maxlength="15" value="<%- tecnico_nombre %>" readonly required>
                                            </div>
                                        </div>
                                        {{--selects--}}
                                        <div class="row">
                                            <label for="orden_tipoorden" class="col-md-1 control-label">Tipo</label>
                                            <div class="form-group col-md-3">
                                                <select name="orden_tipoorden" id="orden_tipoorden" class="form-control select2-default" required>
                                                    <option value="" selected>Seleccione</option>
                                                    @foreach( App\Models\Tecnico\TipoOrden::getTiposOrden() as $key => $value)
                                                        <option value="{{ $key }}" <%- orden_tipoorden == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tipoorden" data-field="orden_tipoorden">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>

                                            <label for="orden_solicitante" class="col-md-1 control-label">Solicitante</label>
                                            <div class="form-group col-md-3">
                                                <select name="orden_solicitante" id="orden_solicitante" class="form-control select2-default" required>
                                                    <option value="" selected>Seleccione</option>
                                                    @foreach( App\Models\Tecnico\Solicitante::getSolicitantes() as $key => $value)
                                                        <option value="{{ $key }}" <%- orden_solicitante == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="solicitante" data-field="orden_solicitante">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>   
                                        
                                        <div class="row">
                                            <label for="orden_dano" class="col-md-1 control-label">Daño</label>
                                            <div class="form-group col-md-3">
                                                <select name="orden_dano" id="orden_dano" class="form-control select2-default" required>
                                                    <option value="" selected>Seleccione</option>
                                                    @foreach( App\Models\Tecnico\Dano::getDanos() as $key => $value)
                                                        <option value="{{ $key }}" <%- orden_dano == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="dano" data-field="orden_dano">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>

                                            <label for="orden_prioridad" class="col-md-1 control-label">Prioridad</label>
                                            <div class="form-group col-md-3">
                                                <select name="orden_prioridad" id="orden_prioridad" class="form-control select2-default" required>
                                                    <option value="" selected="">Seleccione</option>
                                                    @foreach( App\Models\Tecnico\Prioridad::getPrioridad() as $key => $value)
                                                        <option value="{{ $key }}" <%- orden_prioridad == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="prioridad" data-field="orden_prioridad">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label for="orden_llamo" class="col-md-1 control-label">Persona</label>
                                            <div class="form-group col-md-9">
                                                <input id="orden_llamo" type="text" name="orden_llamo" class="form-control" placeholder="Persona" value="<%- orden_llamo %>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="orden_problema" class="col-md-1 control-label">Problema</label>
                                            <div class="form-group col-md-9">
                                                <textarea id="orden_problema" name="orden_problema" class="form-control" rows="2" placeholder="Problema ..."><%- orden_problema %></textarea>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="box-footer with-border">
                                        <div class="row">
                                            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                                                <a href="{{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                                            </div>
                                            <div class="col-md-2 col-sm-6 col-xs-6">
                                                <button type="button" class="btn btn-primary btn-sm btn-block submit-orden">{{ trans('app.save') }}</button>
                                            </div>
                                        </div> 
                                    </div>
                                <% }%>
                            </div>
                        </div>
                    </div>

                    {{-- Content visitas --}}
                    <% if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                        <div class="tab-pane" id="tab_visitas">
                            <div class="box box-whithout-border" id="wrapper-visitas">
                                <div class="box-body">
                                    <form method="POST" accept-charset="UTF-8" id="form-visitas" data-toggle="validator">
                                        <div class="row">
                                            <label for="visita_tercero" class="col-md-offset-1 col-md-1 control-label">Tecnico</label>
                                            <div class="form-group col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="visita_tercero">
                                                            <i class="fa fa-user"></i>
                                                        </button>
                                                    </span>
                                                    <input id="visita_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="visita_tercero" type="text" maxlength="15" data-wrapper="ordenes-create" data-type="tecnico" data-name="visita_terecero_nombre" data-contacto="btn-add-contact" value="<%- tecnico_nit%>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-xs-10">
                                                <input id="visita_terecero_nombre" name="visita_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tecnico_nombre %>" readonly required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="visita_fecha_llegada" class="col-md-1 control-label">F. visita</label>
                                            <div class="form-group col-md-2">
                                                <input type="text" id="visita_fecha_llegada" name="visita_fecha_llegada" class="form-control input-sm datepicker" placeholder="yyyy/mm/dd" required>
                                            </div> 
                                            <label for="visita_hora_llegada" class="col-md-1 control-label">H. visita</label>
                                            <div class="col-md-2">
                                                <div class="bootstrap-timepicker">
                                                     <div class="input-group">
                                                        <input type="text" id="visita_hora_llegada" name="visita_hora_llegada" class="form-control input-sm timepicker" value="" required>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="visita_fecha_inicio" class="col-md-1 control-label">F. inicio</label>
                                            <div class="form-group col-md-2">
                                                <input type="text" id="visita_fecha_inicio" name="visita_fecha_inicio" class="form-control input-sm datepicker" placeholder="yyyy/mm/dd" required>
                                            </div>
                                            <label for="visita_hora_inicio" class="col-md-1 control-label">H. inicio</label>
                                            <div class="col-md-2">
                                                <div class="bootstrap-timepicker">
                                                     <div class="input-group">
                                                        <input type="text" id="visita_hora_inicio" name="visita_hora_inicio" class="form-control input-sm timepicker" value="" required>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="visita_fecha_fin" class="col-md-1 control-label">F. finalización</label>
                                            <div class="form-group col-md-2">
                                                <input type="text" id="visita_fecha_fin" name="visita_fecha_fin" class="form-control input-sm datepicker" placeholder="yyyy/mm/dd" required>
                                            </div> 
                                            <label for="visita_hora_fin" class="col-md-1 control-label">H. finalización</label>
                                            <div class="col-md-2">
                                                <div class="bootstrap-timepicker">
                                                    <div class="input-group">
                                                        <input type="text" id="0" name="visita_hora_fin" class="form-control input-sm timepicker" value="" required>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label  for="visita_tiempo_transporte" class="col-md-1 control-label">T. Transporte</label>
                                            <div class="form-group col-md-2">                                                
                                                <input type="number" min="0" class="form-control input-sm" id="visita_tiempo_transporte" name="visita_tiempo_transporte" value="" required="">
                                            </div>
                                            <label for="visita_viaticos" class="col-md-1 control-label">Viaticos</label>
                                            <div class="form-group col-md-2">
                                                <input type="text" class="form-control input-sm" name="visita_viaticos" id="visita_viaticos" data-currency>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="box-footer with-border">
                                        <div class=" col-sm-2 col-md-offset-5">
                                            <button type="button" class="btn btn-primary btn-sm btn-block submit-visitas">{{ trans('app.add') }}</button>
                                        </div>
                                    </div>
                                    <div class="box box-solid">
                                        <div class=" box-body table-responsive no-padding">
                                            <table id="browse-visitas-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="10%">N. Visita</th>
                                                        <th width="25%">F. Llegada</th>                                                    
                                                        <th width="25%">F. Inicio</th>                                                    
                                                        <th width="30%">N. Tecnico</th>                                                    
                                                        <th width="5%">Info</th>                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content visita-item --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_remisiones">
                            {{-- Content Remisiones --}}
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-2 col-md-offset-4">
                                            <button type="button" class="btn btn-primary btn-sm btn-block click-add-remision">{{ trans('app.add') }}</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-default btn-sm btn-block click-consult-remision">Consultar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="render-main-remisiones">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_imagenes">
                           {{-- Content Images --}}
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="row">
                                        <label for="imagen_visita" class="control-label col-sm-1">Archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_cierre">
                            {{-- Conttent Cierre --}}
                            <div class="row">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-red"><i class="fa fa-hand-paper-o"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>¿Está seguro que desea cerrar la orden ?</strong></span><br>
                                            <div class="col-md-1 col-md-offset-1 col-sm-6 col-xs-6 click-cerrar-orden">
                                                <a href="#" class="btn btn-sm btn-default btn-block">SI</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <% } %>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/template" id="visita-item-list-tpl">       
    <% if(edit && last) { %>
        <td id="td_<%- id %>" class="text-center">
            <a class="btn btn-default btn-xs item-visita-remove" data-resource="<%- id %>">
                <span><i class="fa fa-times"></i></span>
            </a>
        </td>
    <% }else if(edit){ %> 
        <td id="td_<%- id %>" class="text-center"></td>
    <% } %>

    
    <td><%-  visita_numero %></td>
    <td><%-  visita_fh_llegada %></td>
    <td><%-  visita_fh_inicio %></td>
    <td><%-  tercero_nombre %></td>
    
    <td class="text-center">
        <a class="btn btn-default btn-xs item-visita-show-info" data-resource="<%- id %>">
            <span><i class="fa fa-info-circle "></i></span>
        </a>
    </td>
</script>

<script type="text/template" id="remrepu-item-list-tpl">       
    <% if(edit) { %>
        <td class="text-center">
            <a class="btn btn-default btn-xs item-remrepu-remove" data-resource="<%- id %>">
                <span><i class="fa fa-times"></i></span>
            </a>
        </td>
    <% } %>

    <td><%- remrepu2_serie %> </td>
    <td><%- remrepu2_nombre %></td>
    <td><%- remrepu2_cantidad %></td>
</script>

<script type="text/template" id="show-info-visita-tpl">
   <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label">Fecha y hora llegada</label>
            <div><%- visita_fh_llegada %></div>
        </div>

        <div class="form-group col-md-6">
            <label class="control-label">Fecha y hora salida</label>
            <div><%- visita_fh_finaliza %></div>
        </div>      
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label">Tiempo de Transporte</label>
            <div><%- visita_tiempo_transporte == 1 ? visita_tiempo_transporte + ' Hora' : visita_tiempo_transporte + ' Horas' %></div>
        </div>

        <div class="form-group col-md-6">
            <label class="control-label">Viaticos</label>
            <div><%- '$ ' + visita_viaticos.toLocaleString() %></div>
        </div> 
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            <label class="control-label">Tecnico</label>
            <div><%- tercero_nombre %></div>
        </div> 
    </div>


</script>
<script type="text/template" id="add-remision-tpl">
    <div class="row">
        <div class="form-group col-md-3">
            <label for="remrepu2_serie" class="control-label">Producto</label>
            <div class="input-group input-group-sm">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="remrepu2_serie">
                        <i class="fa fa-barcode"></i>
                    </button>
                </span>
                <input id="remrepu2_serie" placeholder="Referencia" class="form-control producto-koi-component" name="remrepu2_serie" type="text" maxlength="15" data-wrapper="producto_create" data-name="remrepu2_nombre" required>
            </div>
        </div>
        <div class="col-md-6 col-xs-10"><br>
            <input id="remrepu2_nombre" name="remrepu2_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" readonly required>
        </div>
        <div class="form-group col-md-2">
            <label for="remrepu2_cantidad" class="control-label">Cantidad</label>
            <input type="number" name="remrepu2_cantidad" id="remrepu2_cantidad" min="1" class="form-control input-sm">
        </div>
        <div class="form-group col-md-1"><br>
            <button type="button" class="btn btn-success btn-sm btn-block click-add-item">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <!-- table table-bordered table-striped -->
    <div class="table-responsive no-padding">
        <table id="browse-orden-remrepu-list" class="table table-hover table-bordered" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%"></th>
                    <th width="10%">Referencia</th>
                    <th width="40%">Nombre</th>
                    <th width="10%">Cantidad</th>
                    
                </tr>
            </thead>
            <tbody>
                {{-- Render content remrepu --}}
            </tbody>
        </table>
    </div>
</script>
<script type="text/template" id="show-remision-tpl">
   <div class="box box-solid">
        <div class="col-md-offset-1 col-md-10">
            <div class="box-body table-responsive no-padding">

                <table id="browse-orden-remision-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Número</th>
                            <th width="50%">Elaboro</th>
                            <th width="20%">Fecha</th>
                            <th width="5%">Info</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</script>
<script type="text/template" id="remision-item-list-tpl">       
    <td><%- remrepu1_numero %></td>
    <td><%- tercero_nombre %></td>
    <td><%- remrepu1_fh_elaboro %></td>
        
    <td class="text-center">
        <a class="btn btn-default btn-xs item-remsion-show-info" data-resource="<%- id %>">
            <span><i class="fa fa-info-circle "></i></span>
        </a>
    </td>
</script>
<script type="text/template" id="remision-show-detail-tpl">
    <div class="row">
        <div class="form-group col-md-3">
            <label class="control-label">N° Remisión</label>
            <div><%- remrepu1_numero %></div>
        </div>
    </div>
        <div class="box box-solid">
            <h5><b>Repuestos</b></h5>
            <div class="box-body table-responsive no-padding">
                <table id="browse-orden-remrepu-show-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Código</th>
                            <th width="80%">Nombre</th>
                            <th width="10%">Cantidad</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
</script>
@stop