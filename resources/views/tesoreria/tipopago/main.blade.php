@extends('layout.layout')

@section('title') Tipo Pago @stop

@section('content')
    <section class="content-header">
        <h1>
            Tipo pago <small>Administración de tipo pago</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-tipopago-tpl">
        <div class="row">
            <div class="form-group col-md-3">
            <label for="tipopago_nombre" class="control-label">Nombre</label>
                <input type="text" id="tipopago_nombre" name="tipopago_nombre" value="<%- tipopago_nombre %>" placeholder="Tipo pago" class="form-control input-sm input-toupper" maxlength="25" required>
            </div>
            <div class="form-group col-md-3">
                <label for="tipopago_documentos" class="control-label">Documento</label>
                <select name="tipopago_documentos" id="tipopago_documentos" class="form-control select2-default">
                    <option value="" selected>Seleccione</option>
                    @foreach( App\Models\Base\Documentos::getDocumentos() as $key => $value)
                        <option value="{{ $key }}" <%- tipopago_documentos == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6 col-md-2">
                <label for="tipopago_plancuentas" class="control-label text-right">Cuenta</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="tipopago_plancuentas">
                            <i class="fa fa-tasks"></i>
                        </button>
                    </span>
                    <input id="tipopago_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="tipopago_plancuentas" type="text" maxlength="15" data-name="tipopago_cuenta_nombre" value="<%- plancuentas_cuenta %>" required>
                </div>
            </div>
            <div class="col-sm-6 col-md-4"><br>
                <input id="tipopago_cuenta_nombre" name="tipopago_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" required disabled>
            </div>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipopago_activo    ">
                    <input type="checkbox" id="tipopago_activo" name="tipopago_activo" value="tipopago_activo" <%- tipopago_activo ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
    </script>
@stop