@extends('layout.layout')

@section('title') Regionales @stop

@section('content')
    <section class="content-header">
        <h1>
            Regionales <small>Administración de regionales</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-regional-tpl">
        <div class="row">
            <div class="form-group col-md-8">
                <label for="regional_nombre" class="control-label">Nombre</label>
                <input type="text" id="regional_nombre" name="regional_nombre" value="<%- regional_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="50" required>
            </div>
            <div class="form-group col-md-2">
                <br><label class="checkbox-inline" for="regional_activo">
                    <input type="checkbox" id="regional_activo" name="regional_activo" value="regional_activo" <%- parseInt(regional_activo) ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
    </script>
@stop