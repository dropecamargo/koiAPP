@extends('layout.layout')

@section('title') Impuestos @stop

@section('content')
    <section class="content-header">
        <h1>
            Impuestos <small>Administración de impuestos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-impuesto-tpl">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="impuesto_nombre" class="control-label">Nombre</label>
                <input type="text" id="impuesto_nombre" name="impuesto_nombre" value="<%- impuesto_nombre %>" placeholder="Impuesto" class="form-control input-sm input-toupper" maxlength="100" required>
            </div>
            <div class="form-group col-md-2">
                <label for="impuesto_porcentaje" class="control-label">Porcentaje %</label>
                <input type="text" id="impuesto_porcentaje" name="impuesto_porcentaje" value="<%- impuesto_porcentaje %>" class="form-control input-sm spinner-percentage" min="0" required>
            </div>
            <div class="form-group col-md-2 col-xs-8 col-sm-3"><br>
                <label class="checkbox-inline" for="impuesto_activo">
                    <input type="checkbox" id="impuesto_activo" name="impuesto_activo" value="impuesto_activo" <%- impuesto_activo ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
    </script>
@stop
