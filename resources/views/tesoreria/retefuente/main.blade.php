@extends('layout.layout')

@section('title') Retefuente @stop

@section('content')
    <section class="content-header">
        <h1>
            Retención de fuente <small>Administración de retenciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-retefuente-tpl">
        <div class="row">
            <div class="form-group col-md-6">
            <label for="retefuente_nombre" class="control-label">Nombre</label>
                <input type="text" id="retefuente_nombre" name="retefuente_nombre" value="<%- retefuente_nombre %>" placeholder="Retefuente" class="form-control input-sm input-toupper" maxlength="25" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-2">
                <label for="retefuente_plancuentas" class="control-label text-right">Cuenta</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="retefuente_plancuentas">
                            <i class="fa fa-tasks"></i>
                        </button>
                    </span>
                    <input id="retefuente_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="retefuente_plancuentas" type="text" maxlength="15" data-wrapper="asientos-create" data-name="retefuente_cuenta_nombre" value="<%- plancuentas_cuenta %>">
                </div>
            </div>
            <div class="col-sm-6 col-md-4"><br>
                <input id="retefuente_cuenta_nombre" name="retefuente_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" disabled>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label for="retefuente_base" class="control-label">Base</label>
                <input type="text" id="retefuente_base" name="retefuente_base" class="form-control input-sm" value="<%- retefuente_base %>" data-currency>
            </div>
            <div class="form-group col-md-2">
                <label for="retefuente_tarifa_natural" class="control-label">Porcentaje tarifa juridico %</label><br>
                <input type="text" id="retefuente_tarifa_natural" name="retefuente_tarifa_natural" value="<%- retefuente_tarifa_natural %>" class="form-control input-sm spinner-percentage" min="0" required>
            </div>
            <div class="form-group col-md-2">
                <label for="retefuente_tarifa_juridico" class="control-label">Porcentaje tarifa juridico %</label><br>
                <input type="text" id="retefuente_tarifa_juridico" name="retefuente_tarifa_juridico" value="<%- retefuente_tarifa_juridico %>" class="form-control input-sm spinner-percentage" min="0" required>
            </div>
            <br>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="retefuente_activo">
                    <input type="checkbox" id="retefuente_activo" name="retefuente_activo" value="retefuente_activo" <%- retefuente_activo ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>

    </script>
@stop