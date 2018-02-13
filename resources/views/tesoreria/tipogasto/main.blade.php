@extends('layout.layout')

@section('title') Tipo Gasto @stop

@section('content')
    <section class="content-header">
        <h1>
            Tipos de gasto <small>Administración tipos de gasto</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-tipogasto-tpl">
        <div class="row">
            <div class="form-group col-md-6">
            <label for="tipogasto_nombre" class="control-label">Nombre</label>
                <input type="text" id="tipogasto_nombre" name="tipogasto_nombre" value="<%- tipogasto_nombre %>" placeholder="Tipo gasto" class="form-control input-sm input-toupper" maxlength="25" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-2">
                <label for="tipogasto_plancuentas" class="control-label text-right">Cuenta</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="tipogasto_plancuentas">
                            <i class="fa fa-tasks"></i>
                        </button>
                    </span>
                    <input id="tipogasto_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="tipogasto_plancuentas" type="text" maxlength="15" data-name="tipogasto_cuenta_nombre" value="<%- plancuentas_cuenta %>" required>
                </div>
            </div>
            <div class="col-sm-6 col-md-4"><br>
                <input id="tipogasto_cuenta_nombre" name="tipogasto_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" required disabled>
            </div>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipogasto_activo    ">
                    <input type="checkbox" id="tipogasto_activo" name="tipogasto_activo" value="tipogasto_activo" <%- tipogasto_activo ? 'checked': ''%>> Activo
                </label>
            </div>

        </div>
    </script>
@stop
