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
                <input type="text" id="tipogasto_nombre" name="tipogasto_nombre" value="<%- tipogasto_nombre %>" placeholder="Tipo gasto" class="form-control input-sm input-toupper" maxlength="50" required>
            </div>
            </br>
            <div class="form-group col-md-2 col-xs-8 col-sm-3">
                <label class="checkbox-inline" for="tipogasto_activo">
                    <input type="checkbox" id="tipogasto_activo" name="tipogasto_activo" value="tipogasto_activo" <%- tipogasto_activo ? 'checked': ''%>> Activo
                </label>
            </div>

        </div>
    </script>
@stop
