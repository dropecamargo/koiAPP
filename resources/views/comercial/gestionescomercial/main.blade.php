@extends('layout.layout')

@section('title') Gestiones comerciales @stop

@section('content')
    <section class="content-header">
        <h1>
            Gestiones comerciales <small>Administración de gestiones comerciales</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-gestioncomercial-tpl">
        <div class="row">
            <label for="gestioncomercial_tercero" class="col-md-1 control-label">Cliente</label>
            <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="gestioncomercial_tercero">
                            <i class="fa fa-user"></i>
                        </button>
                    </span>
                    <input id="gestioncomercial_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="gestioncomercial_tercero" type="text" maxlength="15" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                </div>
            </div>
            <div class="col-md-6 col-xs-10">
                <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
            </div>
        </div>
        <div class="row">
            <label for="gestioncomercial_conceptocom" class="control-label col-md-1">Concepto</label>
            <div class="form-group col-md-3">
                <select name="gestioncomercial_conceptocom" id="gestioncomercial_conceptocom" class="form-control select2-default" required>
                    @foreach( App\Models\Comercial\ConceptoComercial::getConceptoComercial() as $key => $value)
                        <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <label for="gestioncomercial_vendedor" class="col-sm-1 col-md-1 control-label">Vendedor</label>
            <div class="form-group col-sm-5">
                <select name="gestioncomercial_vendedor" id="gestioncomercial_vendedor" class="form-control select2-default">
                    @foreach( App\Models\Base\Tercero::getSellers() as $key => $value)
                    <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <label for="gestioncomercial_inicio" class="col-sm-1 control-label">Fecha inicio</label>
            <div class="form-group col-sm-2">
                <input id="gestioncomercial_inicio" name="gestioncomercial_inicio" class="form-control input-sm datepicker" type="text" value="<%- gestioncomercial_inicio %>" required>
            </div>
            <label for="gestioncomercial_hinicio" class="col-md-1 control-label">Hora inicio</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestioncomercial_hinicio" name="gestioncomercial_hinicio" class="form-control input-sm timepicker" value="" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <label for="gestioncomercial_finalizo" class="col-sm-1 control-label">Fecha finalización</label>
            <div class="form-group col-sm-2">
                <input id="gestioncomercial_finalizo" name="gestioncomercial_finalizo" class="form-control input-sm datepicker" type="text" value="<%- gestioncomercial_finalizo %>" required>
            </div>
            <label for="gestioncomercial_hfinalizo" class="col-md-1 control-label">Hora finalización</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestioncomercial_hfinalizo" name="gestioncomercial_hfinalizo" class="form-control input-sm timepicker" value="" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="gestioncomercial_observaciones" class="col-sm-1 control-label">Observaciones</label>
            <div class="form-group col-sm-11">
                <textarea id="gestioncomercial_observaciones" name="gestioncomercial_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
            </div>
        </div>
    </script>

@stop
