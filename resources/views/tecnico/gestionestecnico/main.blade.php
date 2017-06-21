@extends('layout.layout')

@section('title') Gestión tecnico @stop

@section('content')
    <section class="content-header">
        <h1>
            Gestión tecnico <small>Administración de gestión tecnico</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-gestiontecnico-tpl">
        <div class="row">
            <label for="gestiontecnico_tercero" class="col-md-1 control-label">Cliente</label>
            <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="gestiontecnico_tercero">
                            <i class="fa fa-user"></i>
                        </button>
                    </span>
                    <input id="gestiontecnico_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="gestiontecnico_tercero" type="text" maxlength="15" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                </div>
            </div>
            <div class="col-md-6 col-xs-10">
                <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
            </div>
        </div>
        <div class="row">
            <label for="gestiontecnico_conceptotec" class="control-label col-md-1">Concepto</label>
            <div class="form-group col-md-3">
                <select name="gestiontecnico_conceptotec" id="gestiontecnico_conceptotec" class="form-control select2-default" required>
                    @foreach( App\Models\Tecnico\ConceptoTecnico::getConceptoTecnico() as $key => $value)
                        <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <label for="gestiontecnico_tecnico" class="col-sm-1 col-md-1 control-label">Tecnico</label>
            <div class="form-group col-sm-5">
                <select name="gestiontecnico_tecnico" id="gestiontecnico_tecnico" class="form-control select2-default">
                    @foreach( App\Models\Base\Tercero::getTechnicals() as $key => $value)
                    <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>  
        <div class="row">
            <label for="gestiontecnico_inicio" class="col-sm-1 control-label">Fecha inicio</label>
            <div class="form-group col-sm-2">     
                <input id="gestiontecnico_inicio" name="gestiontecnico_inicio" class="form-control input-sm datepicker" type="text" value="<%- gestiontecnico_inicio %>" required>
            </div>
            <label for="gestiontecnico_hinicio" class="col-md-1 control-label">Hora inicio</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestiontecnico_hinicio" name="gestiontecnico_hinicio" class="form-control input-sm timepicker" value="" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div> 
            <label for="gestiontecnico_finalizo" class="col-sm-1 control-label">Fecha finalización</label>
            <div class="form-group col-sm-2">     
                <input id="gestiontecnico_finalizo" name="gestiontecnico_finalizo" class="form-control input-sm datepicker" type="text" value="<%- gestiontecnico_finalizo %>" required>
            </div>
            <label for="gestiontecnico_hfinalizo" class="col-md-1 control-label">Hora finalización</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestiontecnico_hfinalizo" name="gestiontecnico_hfinalizo" class="form-control input-sm timepicker" value="" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
            <label for="gestiontecnico_observaciones" class="col-sm-1 control-label">Observaciones</label>
            <div class="form-group col-sm-11">
                <textarea id="gestiontecnico_observaciones" name="gestiontecnico_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
            </div>
        </div> 
    </script>

@stop