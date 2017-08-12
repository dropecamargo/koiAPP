@extends('layout.layout')

@section('title') Tipo activo @stop

@section('content')
    <section class="content-header">
        <h1>
            Tipo activo <small>Administración de tipo activo</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-tipoactivo-tpl">
        <div class="row">
            <div class="form-group col-md-5">
            <label for="tipoactivo_nombre" class="control-label">Nombre</label>
                <input type="text" id="tipoactivo_nombre" name="tipoactivo_nombre" value="<%- tipoactivo_nombre %>" placeholder="Tipo activo" class="form-control input-sm input-toupper" maxlength="25" required>
            </div>
            <div class="form-group col-md-1">
            <label for="tipoactivo_vida_util" class="control-label">Vidad útil</label>
                <input type="number" id="tipoactivo_vida_util" name="tipoactivo_vida_util" value="<%- tipoactivo_vida_util %>" class="form-control input-sm" min="1" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-2">
                <label for="tipoactivo_plancuentas" class="control-label text-right">Cuenta</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="tipoactivo_plancuentas">
                            <i class="fa fa-tasks"></i>
                        </button>
                    </span>
                    <input id="tipoactivo_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="tipoactivo_plancuentas" type="text" maxlength="15" data-name="tipoactivo_cuenta_nombre" value="<%- plancuentas_cuenta %>" required>
                </div>
            </div>
            <div class="col-sm-6 col-md-4"><br>
                <input id="tipoactivo_cuenta_nombre" name="tipoactivo_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" required disabled>
            </div>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipoactivo_activo    ">
                    <input type="checkbox" id="tipoactivo_activo" name="tipoactivo_activo" value="tipoactivo_activo" <%- tipoactivo_activo ? 'checked': ''%>> Activo
                </label>
            </div>

        </div>
    </script>
@stop