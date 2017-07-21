@extends('layout.layout')

@section('title') Ordenes @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="add-orden-tpl">
         <section class="content-header">
            <h1>
                Ordenes <small>Administración de ordenes</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
                    <li><a href="{{ route('ordenes.index') }}">Ordenes</a></li>
                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li><a href="<%- window.Misc.urlFull( Route.route('ordenes.show', { ordenes: id}) ) %>"><%- id %></a></li>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-solid" id="spinner-main">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_orden" data-toggle="tab">Orden</a></li>
                                <% if( typeof(orden_serie) !== 'undefined' && !_.isUndefined(orden_serie) && !_.isNull(orden_serie) && orden_serie != '') { %>
                                    <li><a href="#tab_visitas" data-toggle="tab">Visitas</a></li>
                                    <li><a href="#tab_remisiones" data-toggle="tab">Remisiones</a></li>
                                    <li><a href="#tab_legalizacion" data-toggle="tab">Legalización</a></li>
                                    <li><a href="#tab_imagenes" data-toggle="tab">Imagenes</a></li>
                                    <li><a href="#tab_cierre" data-toggle="tab">Cierre</a></li>
                                <% } %>
                            </ul>
                            <div class="tab-content" >
                                {{-- Content orden --}}
                                <div class="tab-pane active" id="tab_orden">
                                    <div class="box box-whithout-border">
                                        <div class="box-body">
                                            <form method="POST" accept-charset="UTF-8" id="form-orden" data-toggle="validator">
                                                <div class="row">
                                                    <% if( !_.isUndefined(edit) && !_.isNull(edit) && !edit ) { %>
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
                                                        <div class="form-group col-md-2">
                                                            <input type="text" id="orden_fecha_servicio" name="orden_fecha_servicio" class="form-control input-sm datepicker" value="<%- orden_fecha_servicio %>" required>
                                                        </div> 
                                                        <label for="orden_hora_servicio" class="col-md-1 control-label">H. Servicio</label>
                                                        <div class="form-group col-md-2">
                                                            <div class="bootstrap-timepicker">
                                                                <div class="input-group">
                                                                    <input type="text" id="orden_hora_servicio" name="orden_hora_servicio" placeholder="Fecha servicio" class="form-control input-sm timepicker" value="<%- orden_hora_servicio %>" required>
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <% }else{ %>
                                                        <div class="form-group col-sm-2">
                                                            <label class="control-label">Sucursal</label>
                                                            <div><%- sucursal_nombre %></div>
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label class="control-label">Número</label>
                                                            <div><%- orden_numero %></div>
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="orden_fecha_servicio" class="control-label">F. Servicio</label>
                                                            <input type="text" id="orden_fecha_servicio" name="orden_fecha_servicio" class="form-control input-sm datepicker" value="<%- orden_fecha_servicio %>" required>
                                                        </div> 
                                                        <div class="form-group col-md-2">
                                                            <label for="orden_hora_servicio" class="control-label">H. Servicio</label>
                                                            <div class="bootstrap-timepicker">
                                                                <div class="input-group">
                                                                    <input type="text" id="orden_hora_servicio" name="orden_hora_servicio" placeholder="Fecha servicio" class="form-control input-sm timepicker" value="<%- orden_hora_servicio %>" required>
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <% } %>
                                                </div>

                                                <% if( !_.isUndefined(edit) && !_.isNull(edit) && !edit ) { %>
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
                                                        <div class="col-md-8 col-xs-12">
                                                            <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="tcontacto_nombre" class="col-sm-1 control-label">Contacto</label>
                                                        <div class="form-group col-md-3 col-sm-2 col-xs-10">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-contacto-component-table" data-field="orden_contacto" data-name="tcontacto_nombre" data-email="tcontacto_email" data-phone="tcontacto_telefono" data-tercero="btn-add-contact">
                                                                        <i class="fa fa-address-book"></i>
                                                                    </button>
                                                                </span>
                                                                <input id="orden_contacto" name="orden_contacto" type="hidden" value="<%- orden_contacto %>">
                                                                <input id="tcontacto_nombre" placeholder="Contacto" class="form-control" name="tcontacto_nombre" value="<%- tcontacto_nombre %>" type="text" readonly required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 col-md-1 col-xs-2">
                                                            <button type="button" id="btn-add-contact" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="contacto" data-field="orden_contacto" data-name="tcontacto_nombre" data-tercero="<%- orden_tercero %>">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>

                                                        <div class="form-group col-sm-3">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="tcontacto_telefono" class="form-control input-sm" placeholder="Telefono" name="tcontacto_telefono" value="<%- tcontacto_telefono %>" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask readonly required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-4">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-envelope-o"></i>
                                                                </div>
                                                                <input id="tcontacto_email" class="form-control input-sm" placeholder="Correo" name="tcontacto_email" value="<%- tcontacto_email %>" type="text" readonly required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <% }else{ %>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Tercero</label>
                                                            <div>
                                                                Documento: <%- tercero_nit %>
                                                                <br>
                                                                Nombre: <%- tercero_nombre %>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Contacto</label>
                                                            <div>
                                                                Nombre: <%- tcontacto_nombre %>
                                                                <br>
                                                                Telefono: <%- tcontacto_telefono %>
                                                                <br>
                                                                Correo: <%- tcontacto_email %>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <% } %>

                                                {{--producto--}}
                                                <div class="row">
                                                    <% if( !_.isUndefined(edit) && !_.isNull(edit) && !edit ) { %>
                                                        <label for="orden_fecha" class="col-md-1 control-label">Producto</label>
                                                        <div class="form-group col-md-3">
                                                    <% }else{ %>
                                                        <div class="form-group col-md-3">
                                                            <label for="orden_fecha" class="control-label">Producto</label>
                                                    <% } %>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="orden_serie" >
                                                                    <i class="fa fa-barcode"></i>
                                                                </button>
                                                            </span>
                                                            <input id="orden_serie" placeholder="Serie" class="form-control producto-koi-component" name="orden_serie" type="text" maxlength="15" data-wrapper="producto_create" data-tercero="true" data-name="orden_nombre_producto" value="<%- producto_serie %>">
                                                        </div>
                                                    </div>
                                                    <div class="<%- edit ? 'col-md-5' : 'col-md-8' %> col-xs-12">
                                                        <% if( edit ) { %>
                                                            <br>
                                                        <% } %>
                                                        <input id="orden_nombre_producto" name="orden_nombre_producto" placeholder="Nombre producto" class="form-control input-sm" type="text" value="<%- producto_nombre %>" readonly>
                                                    </div>
                                                </div>

                                                <% if( !_.isUndefined(edit) && !_.isNull(edit) && !edit ) { %>
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
                                                                <input id="orden_tecnico" placeholder="Tecnico" class="form-control tercero-koi-component" name="orden_tecnico" type="text" maxlength="15" data-type="tecnico" data-tecnico="true" data-name="orden_tecnico_nombre" value="<%- tecnico_nit %>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <input id="orden_tecnico_nombre" name="orden_tecnico_nombre" placeholder="Nombre Tecnico" class="form-control input-sm" type="text" maxlength="15" value="<%- tecnico_nombre %>" readonly required>
                                                        </div>
                                                    </div>
                                                    {{--selects--}}
                                                    <div class="row">
                                                        <label for="orden_tipoorden" class="col-md-1 col-xs-12 control-label">Tipo</label>
                                                        <div class="form-group col-md-3 col-xs-11">
                                                            <select name="orden_tipoorden" id="orden_tipoorden" class="form-control select2-default" required>
                                                                @foreach( App\Models\Tecnico\TipoOrden::getTiposOrden() as $key => $value)
                                                                    <option value="{{ $key }}" <%- orden_tipoorden == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1 col-xs-1">
                                                            <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tipoorden" data-field="orden_tipoorden">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <label for="orden_solicitante" class="col-md-1 col-xs-12 control-label">Solicitante</label>
                                                        <div class="form-group col-md-3 col-xs-11">
                                                            <select name="orden_solicitante" id="orden_solicitante" class="form-control select2-default" required>
                                                                @foreach( App\Models\Tecnico\Solicitante::getSolicitantes() as $key => $value)
                                                                    <option value="{{ $key }}" <%- orden_solicitante == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1 col-xs-1">
                                                            <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="solicitante" data-field="orden_solicitante">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>   
                                                    <div class="row">
                                                        <label for="orden_dano" class="col-md-1 col-xs-12 control-label">Daño</label>
                                                        <div class="form-group col-md-3 col-xs-11">
                                                            <select name="orden_dano" id="orden_dano" class="form-control select2-default" required>
                                                                @foreach( App\Models\Tecnico\Dano::getDanos() as $key => $value)
                                                                    <option value="{{ $key }}" <%- orden_dano == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1 col-xs-1">
                                                            <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="dano" data-field="orden_dano">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <label for="orden_prioridad" class="col-md-1 col-xs-12 control-label">Prioridad</label>
                                                        <div class="form-group col-md-3 col-xs-11">
                                                            <select name="orden_prioridad" id="orden_prioridad" class="form-control select2-default" required>
                                                                @foreach( App\Models\Tecnico\Prioridad::getPrioridad() as $key => $value)
                                                                    <option value="{{ $key }}" <%- orden_prioridad == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1 col-xs-1">
                                                            <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="prioridad" data-field="orden_prioridad">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="orden_sitio" class="col-md-1 col-xs-12 control-label">Sitio de atención</label>
                                                        <div class="form-group col-md-3 col-xs-11">
                                                            <select name="orden_sitio" id="orden_sitio" class="form-control select2-default" required>
                                                                @foreach( App\Models\Tecnico\Sitio::getSitios() as $key => $value)
                                                                    <option value="{{ $key }}" <%- orden_sitio == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1 col-xs-1">
                                                            <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="sitio" data-field="orden_sitio">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="orden_llamo" class="col-md-1 control-label">Persona</label>
                                                        <div class="form-group col-md-11">
                                                            <input id="orden_llamo" type="text" name="orden_llamo" class="form-control" placeholder="Persona" value="<%- orden_llamo %>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="orden_problema" class="col-md-1 control-label">Problema</label>
                                                        <div class="form-group col-md-11">
                                                            <textarea id="orden_problema" name="orden_problema" class="form-control" rows="2" placeholder="Problema ..."><%- orden_problema %></textarea>
                                                        </div>
                                                    </div>
                                                <% } else { %>
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
                                                        <div class="form-group col-md-3">
                                                            <label class="control-label">Tipo</label>
                                                            <div> <%- tipoorden_nombre %> </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            <label class="control-label">Prioridad</label>
                                                            <div> <%- prioridad_nombre %> </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label class="control-label">Sitio de atención</label>
                                                            <div> <%- sitio_nombre %> </div>
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
                                                <% } %>
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

                                                    <div class="row">
                                                        <label  for="visita_observaciones" class="col-md-1 control-label">Observaciones</label>
                                                        <div class="form-group col-md-11">
                                                            <textarea id="visita_observaciones" name="visita_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
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
                                        <div class="box box-solid" id="wrapper-remision">
                                            <div class="box-body">
                                                <form method="POST" accept-charset="UTF-8" id="form-remision" data-toggle="validator">
                                                    <div class="row">
                                                        <div class="form-group col-sm-3 col-md-offset-3">
                                                            <label for="remrempu1_tecnico" class="control-label">Tecnico</label>
                                                            <select name="remrempu1_tecnico" id="remrempu1_tecnico" class="form-control select2-default-clear" required>
                                                                @foreach( App\Models\Base\Tercero::getTechnicals() as $key => $value)
                                                                <option  value="{{ $key }}">{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-sm-3">
                                                            <label for="remrempu1_sucursal" class="control-label">Sucursal</label>
                                                            <select name="remrempu1_sucursal" id="remrempu1_sucursal" class="form-control select2-default-clear" required>
                                                                @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                                                <option  value="{{ $key }}">{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="box-header">
                                                        <div class="col-md-offset-5 col-sm-2">
                                                            <button type="button" class="btn btn-primary btn-sm btn-block click-add-remision">{{ trans('app.add') }}</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-10">
                                                        <div class="box-body table-responsive no-padding">
                                                            <table id="browse-orden-remision-list" class="table table-hover table-bordered" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%">Número</th>
                                                                        <th width="50%">Tecnico</th>
                                                                        <th width="20%">Sucursal</th>
                                                                        <th width="5%">Info</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_legalizacion">
                                        {{-- Content Legalizaciones --}}
                                        <div class="box box-solid" id="wrapper-legalizacion">
                                            <div class="box-body">
                                                <form method="POST" accept-charset="UTF-8" id="form-legalizacion" data-toggle="validator">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="box-body table-responsive no-padding">
                                                                <table id="browse-legalizacion-list" class="table table-hover table-bordered" cellspacing="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%">Sucursal</th>
                                                                            <th width="5%"># R.</th>
                                                                            <th width="40%">Producto</th>
                                                                            <th width="5%">Cantidad</th>
                                                                            <th width="10%">Facturado</th>
                                                                            <th width="10%">No Facturado</th>
                                                                            <th width="10%">Devuelto</th>
                                                                            <th width="10%">Usado</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer">
                                                        <div class="col-md-offset-5 col-sm-2">
                                                            <button type="button" class="btn btn-primary btn-sm btn-block submit-legalizacion">{{ trans('app.add') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab_imagenes">
                                       {{-- Content Images --}}
                                        <div id="fine-uploader"></div>
                                    </div>
                                    <div class="tab-pane" id="tab_cierre">
                                        {{-- Conttent Cierre --}}
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4">
                                                        <div class="info-box">
                                                            <span class="info-box-icon bg-red"><i class="fa fa-hand-paper-o"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number"><h5><b>¿Está seguro que desea cerrar la orden?</b></h5></span>
                                                                <span>
                                                                    <div class="col-sm-2 col-sm-offset-10 click-cerrar-orden">
                                                                        <a href="#" class="btn btn-sm btn-default">SI</a>
                                                                    </div>
                                                                </span>
                                                            </div>
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
            </div>
        </section>
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

        
        <td><%- visita_numero %></td>
        <td><%- visita_fh_llegada %></td>
        <td><%- visita_fh_inicio %></td>
        <td><%- tercero_nombre %></td>
        
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
                <div><%- window.Misc.currency( visita_viaticos ) %></div>
            </div> 
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label class="control-label">Tecnico</label>
                <div><%- tercero_nombre %></div>
            </div> 
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label class="control-label">Observaciones</label>
                <div><%- visita_observaciones %></div>
            </div> 
        </div>
    </script>

    <script type="text/template" id="remision-item-list-tpl">
        <td><%- remrepu1_numero %></td>
        <td><%- tecnico_nombre %></td>
        <td><%- sucursal_nombre %></td>
            
        <td class="text-center">
            <a class="btn btn-default btn-xs item-remsion-show-info" data-resource="<%- id %>">
                <span><i class="fa fa-info-circle "></i></span>
            </a>
        </td>
    </script>

    <script type="text/template" id="legalizacion-item-list-tpl">    
        <td><%- sucursal_nombre %></td>
        <td><%- remrepu1_numero %></td>
        <td><%- remrepu2_nombre %></td>
        <td><%- remrepu2_cantidad %></td>
        <td class="form-group">
            <input id="facturado_<%- id %>" name="facturado_<%- id %>" class="form-control input-sm sum-cantidad" type="number" min="0" max="<%- remrepu2_cantidad %>" value="<%- remrepu2_facturado %>" step="1" data-id="<%- id %>">
        </td>
        <td class="form-group">
            <input id="nofacturado_<%- id %>" name="nofacturado_<%- id %>" class="form-control input-sm sum-cantidad" type="number" min="0" max="<%- remrepu2_cantidad %>" value="<%- remrepu2_no_facturado %>" step="1" data-id="<%- id %>">
        </td>
        <td class="form-group">
            <input id="devuelto_<%- id %>" name="devuelto_<%- id %>" class="form-control input-sm sum-cantidad" type="number" min="0" max="<%- remrepu2_cantidad %>" value="<%- remrepu2_devuelto %>" step="1" data-id="<%- id %>">
        </td>
        <td class="form-group">
            <input id="usado_<%- id %>" name="usado_<%- id %>" class="form-control input-sm sum-cantidad" type="number" min="0" max="<%- remrepu2_cantidad %>" value="<%- remrepu2_usado %>" step="1" data-id="<%- id %>">
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
                <table id="browse-legalizacion-list" class="table table-hover table-bordered" cellspacing="0">
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
            <table id="browse-legalizacions-list" class="table table-hover table-bordered" cellspacing="0">
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

    <script type="text/template" id="orden-sendmail-confirm-tpl">
        <p>¿Desea enviar un correo con la información a <b><%- tcontacto_email %></b>?</p>
    </script>
@stop