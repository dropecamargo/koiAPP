@extends('layout.layout')

@section('title') Autorizaciones @stop

@section('content')
    <section class="content-header">
        <h1>
            Autorizaciones de cartera <small>Administración de autorizaciones </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-autorizaca-tpl" >
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-autorizaca" data-toggle="validator">
                <div class="row">
                    <label for="autorizaca_tercero" class="col-sm-1 control-label">Tercero</label>
                    <div class="form-group col-sm-3">
                        <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="autorizaca_tercero">
                                <i class="fa fa-user"></i>
                            </button>
                        </span>
                        <input id="autorizaca_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="autorizaca_tercero" type="text" maxlength="15" data-wrapper="autorizaca-create" data-name="autorizaca_terecero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-10">
                        <input id="autorizaca_terecero_nombre" name="autorizaca_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tercero" data-field="autorizaca_tercero">
                        <i class="fa fa-plus"></i>
                        </button>
                    </div>                                             
                </div>
                <div class="row">
                    <label for="autorizaca_plazo" class="col-sm-1 control-label">Plazo</label>
                    <div class="form-group col-sm-1">     
                        <input id="autorizaca_plazo" name="autorizaca_plazo" class="form-control input-sm" type="number" min="1" value="<%- autorizaca_plazo %>" required>
                    </div>

                    <label for="autorizaca_plazo" class="col-sm-1 control-label">Cupo</label>
                    <div class="form-group col-sm-1">     
                        <input id="autorizaca_cupo" name="autorizaca_cupo" class="form-control input-sm" type="number" min="1" value="<%- autorizaca_cupo %>" required>
                    </div>

                    <label for="autorizaca_vencimiento" class="col-sm-1 control-label">F.Vencimiento</label>
                    <div class="form-group col-sm-2">
                        <input type="text" id="autorizaca_vencimiento" name="autorizaca_vencimiento" class="form-control input-sm datepicker" value="<%- autorizaca_vencimiento %>" required>
                    </div>
                </div>

                <div class="row">
                    <label for="autorizaca_observaciones" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-md-10">
                        <textarea id="autorizaca_observaciones" name="autorizaca_observaciones" class="form-control" rows="2" placeholder="Observaciones"><%- autorizaca_observaciones %></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                        <a href="{{ route('autorizacionesca.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </script>
@stop