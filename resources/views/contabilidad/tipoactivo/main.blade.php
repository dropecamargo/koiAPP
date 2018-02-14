@extends('layout.layout')

@section('title') Tipos activos @stop

@section('content')
    <section class="content-header">
        <h1>
            Tipos de activos <small>Administración de tipos activos</small>
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
                <input type="text" id="tipoactivo_nombre" name="tipoactivo_nombre" value="<%- tipoactivo_nombre %>" placeholder="Tipo activo" class="form-control input-sm input-toupper" maxlength="50" required>
            </div>
            <div class="form-group col-md-1">
            <label for="tipoactivo_vida_util" class="control-label">Vidad útil</label>
                <input type="number" id="tipoactivo_vida_util" name="tipoactivo_vida_util" value="<%- tipoactivo_vida_util %>" class="form-control input-sm" min="1" required>
            </div>
            </br>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipoactivo_activo">
                    <input type="checkbox" id="tipoactivo_activo" name="tipoactivo_activo" value="tipoactivo_activo" <%- tipoactivo_activo ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
    </script>
@stop
