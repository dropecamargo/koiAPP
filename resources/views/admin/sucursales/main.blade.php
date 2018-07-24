@extends('layout.layout')

@section('title') Sucursales @stop

@section('content')
    <section class="content-header">
        <h1>
            Sucursales <small>Administración de sucursales</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    {{--template Sucursal--}}
    <script type="text/template" id="add-sucursal-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-sucursales" data-toggle="validator">
                <div class="row">
                    <div class="form-group col-sm-8">
                        <label for="sucursal_nombre" class="control-label">Nombre</label>
                        <input type="text" id="sucursal_nombre" name="sucursal_nombre" value="<%- sucursal_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="50" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="sucursal_telefono" class="control-label">Teléfono</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </span>
                            <input type="text" id="sucursal_telefono" name="sucursal_telefono" value="<%- sucursal_telefono %>" placeholder="Telefono" class="form-control input-sm" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-5">
                        <label for="sucursal_direccion" class="control-label">Dirección</label> <small id="sucursal_dir_nomenclatura"><%- sucursal_direccion_nomenclatura %></small>
                        <div class="input-group input-group-sm">
                            <input type="hidden" id="sucursal_direccion_nomenclatura" name="sucursal_direccion_nomenclatura" value="<%- sucursal_direccion_nomenclatura %>">
                            <input id="sucursal_direccion" value="<%- sucursal_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="sucursal_direccion" type="text" maxlength="200" required data-nm-name="sucursal_dir_nomenclatura" data-nm-value="sucursal_direccion_nomenclatura">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="sucursal_direccion">
                                    <i class="fa fa-map-signs"></i>
                                </button>
                            </span>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="sucursal_regional" class="control-label">Regional</label>
                        <select name="sucursal_regional" id="sucursal_regional" class="form-control select2-default-clear" required >
                            @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                                <option value="{{ $key }}" <%- sucursal_regional == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-sm-2"><br>
                        <label class="checkbox-inline" for="sucursal_activo">
                            <input type="checkbox" id="sucursal_activo" name="sucursal_activo" value="sucursal_activo" <%- parseInt(sucursal_activo) ? 'checked': ''%>> Activo
                        </label>
                    </div>
                </div>

                <div class="row">
                    <% if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                        <div class="form-group col-sm-4">
                            <label for="sucursal_defecto" class="control-label">Ubicación por defecto</label>
                            <select name="sucursal_defecto" id="sucursal_defecto" class="form-control select2-default-clear"> </select>
                        </div>
                        <div class="form-group col-sm-1" ><br>
                            <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="ubicacion" data-field="sucursal_defecto" data-parameter = "false" data-sucursal = "<%- id %>">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <div class="form-group col-sm-2"><br>
                            <label class="checkbox-inline" for="sucursal_ubicaciones">
                                <input type="checkbox" id="sucursal_ubicaciones" name="sucursal_ubicaciones" class="changed-location" value="sucursal_ubicaciones" <%- parseInt(sucursal_ubicaciones) ? 'checked': ''%>>  ¿ Maneja ubicación ?
                            </label>
                        </div>
                    <% }else{ %>
                        <div class=" form-group col-sm-4">
                            <label for="sucursal_defecto" class="control-label">Ubicación por defecto</label>
                            <input type="text" name="sucursal_defecto" id="sucursal_defecto" class="form-control input-sm input-toupper" placeholder="Ubicación por defecto">
                        </div>
                    <% } %>
                </div>

                <div class="box-footer with-border">
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                            <a href="{{ route('sucursales.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                        </div>
                        <div class="col-sm-2 col-xs-6 text-right">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>
            </form><br>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Imágenes</h3>
                </div>

                <div class="box-body">
                    <div class="fine-uploader"></div>
                </div>
            </div>
        </div>
    </script>
@stop
