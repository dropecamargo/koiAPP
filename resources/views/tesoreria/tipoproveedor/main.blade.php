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
            </br>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipoproveedor_activo">
                    <input type="checkbox" id="tipoproveedor_activo" name="tipoproveedor_activo" value="tipoproveedor_activo" <%- tipoproveedor_activo ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
    </script>
@stop
