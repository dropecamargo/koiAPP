@extends('layout.layout')

@section('title') Gestion cobro @stop

@section('content')
    <section class="content-header">
        <h1>
            Gestion Cobro <small>Administración de cobros</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-gestioncobro-tpl">
        <div class="row">
            <label for="gestioncobro_tercero" class="col-md-1 control-label">Cliente</label>
            <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="gestioncobro_tercero">
                            <i class="fa fa-user"></i>
                        </button>
                    </span>
                    <input id="gestioncobro_tercero" placeholder="Cliente" class="form-control tercero-koi-component gestioncobro-koi-tercero" name="gestioncobro_tercero" type="text" maxlength="15" data-wrapper="gestioncobro-create" data-name="tercero_nombre" value="<%- tercero_nit %>"  data-change="true" data-tercero="" required>
                </div>
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 col-xs-10">
                <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="gestioncobro_conceptocob" class="control-label col-md-1">Concepto</label>
            <div class="form-group col-md-3">
                <select name="gestioncobro_conceptocob" id="gestioncobro_conceptocob" class="form-control select2-default" required>
                    @foreach( App\Models\Cartera\ConceptoCob::getConceptoCobro() as $key => $value)
                        <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <label for="gestioncobro_proxima" class="col-sm-1 control-label">Fecha proxima</label>
            <div class="form-group col-sm-2">
                <input id="gestioncobro_proxima" name="gestioncobro_proxima" class="form-control input-sm datepicker" type="text" value="<%- gestioncobro_proxima %>" required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="gestioncobro_hproxima" class="col-md-1 control-label">Hora proxima</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestioncobro_hproxima" name="gestioncobro_hproxima" placeholder="Fhproxima" class="form-control input-sm timepicker" value="<%- gestioncobro_hproxima %>" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="gestioncobro_observaciones" class="col-sm-1 control-label">Observaciones</label>
            <div class="form-group col-sm-11">
                <textarea id="gestioncobro_observaciones" name="gestioncobro_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
            </div>
        </div>
        <table id="browse-factura3-list" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th width="5%">Numero</th>
                    <th>Sucursal</th>
                    <th width="15%">Cuota</th>
                    <th>Fecha</th>
                    <th>Vencimiento</th>
                    <th width="5%">N. Dias</th>
                    <th>Saldo</th>
                    <th width="5%"></th>
                </tr>
           </thead>
           <tbody>
                {{-- Render facura3 list --}}
           </tbody>
           <tfoot>
                {{--Render tfoot --}}
           </tfoot>
        </table>
    </script>

@stop
