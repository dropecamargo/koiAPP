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
        <div class="row">
            <div class="form-group col-md-8">
                <label for="sucursal_nombre" class="control-label">Nombre</label>
                <input type="text" id="sucursal_nombre" name="sucursal_nombre" value="<%- sucursal_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="50" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="sucursal_telefono" class="control-label">Teléfono</label>
                <input type="text" id="sucursal_telefono" name="sucursal_telefono" value="<%- sucursal_telefono %>" placeholder="Telefono" class="form-control input-sm" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
            </div>
            <div class="form-group col-md-4">
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
            </div>
            <div class="form-group col-md-2">
                <br><label class="checkbox-inline" for="sucursal_activo">
                    <input type="checkbox" id="sucursal_activo" name="sucursal_activo" value="sucursal_activo" <%- parseInt(sucursal_activo) ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="sucursal_regional" class="control-label">Regional</label>
                <select name="sucursal_regional" id="sucursal_regional" class="form-control select2-default-clear" required >
                    @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                        <option value="{{ $key }}" <%- sucursal_regional == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </script>
@stop