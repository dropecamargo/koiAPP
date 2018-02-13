@extends('layout.layout')

@section('title') Tipo proveedores @stop

@section('content')
    <section class="content-header">
        <h1>
            Tipos de proveedor <small>Administración tipos de proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-tipoproveedor-tpl">
        <div class="row">
            <div class="form-group col-md-6">
            <label for="tipoproveedor_nombre" class="control-label">Nombre</label>
                <input type="text" id="tipoproveedor_nombre" name="tipoproveedor_nombre" value="<%- tipoproveedor_nombre %>" placeholder="Tipo proveedor" class="form-control input-sm input-toupper" maxlength="25" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-2">
                <label for="tipoproveedor_plancuentas" class="control-label text-right">Cuenta</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="tipoproveedor_plancuentas">
                            <i class="fa fa-tasks"></i>
                        </button>
                    </span>
                    <input id="tipoproveedor_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="tipoproveedor_plancuentas" type="text" maxlength="15" data-name="tipoproveedor_cuenta_nombre" value="<%- plancuentas_cuenta %>" required>
                </div>
            </div>
            <div class="col-sm-6 col-md-4"><br>
                <input id="tipoproveedor_cuenta_nombre" name="tipoproveedor_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" required disabled>
            </div>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipoproveedor_activo    ">
                    <input type="checkbox" id="tipoproveedor_activo" name="tipoproveedor_activo" value="tipoproveedor_activo" <%- tipoproveedor_activo ? 'checked': ''%>> Activo
                </label>
            </div>

        </div>
    </script>
@stop
