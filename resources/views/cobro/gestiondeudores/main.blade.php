@extends('layout.layout')

@section('title') Gestión de cartera @stop

@section('content')
    <section class="content-header">
        <h1>
            Gestión de deudor <small>Administración de gestión de deudores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-gestiondeudor-tpl">
        <div class="row">
            <label for="gestiondeudor_tercero" class="col-md-1 control-label">Cliente</label>
            <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="gestiondeudor_tercero">
                            <i class="fa fa-user"></i>
                        </button>
                    </span>
                    <input id="gestiondeudor_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="gestiondeudor_tercero" type="text" maxlength="15" data-wrapper="gestiondeudor-create" data-name="tercero_nombre" required>
                </div>
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-4">
                <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" readonly required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="gestiondeudor_deudor" class="control-label col-md-1">Deudor</label>
            <div class="form-group col-md-3">
                <select name="gestiondeudor_deudor" id="gestiondeudor_deudor" class="form-control select2-default" required disabled>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="gestiondeudor_conceptocob" class="control-label col-md-1">Concepto</label>
            <div class="form-group col-md-3">
                <select name="gestiondeudor_conceptocob" id="gestiondeudor_conceptocob" class="form-control select2-default" required>
                    @foreach( App\Models\Cartera\ConceptoCob::getConceptoCobro() as $key => $value)
                        <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <label for="gestiondeudor_proxima" class="col-sm-1 control-label">Fecha proxima</label>
            <div class="form-group col-sm-2">
                <input id="gestiondeudor_proxima" name="gestiondeudor_proxima" class="form-control input-sm datepicker" type="text" required>
                <div class="help-block with-errors"></div>
            </div>
            <label for="gestiondeudor_hproxima" class="col-md-1 control-label">Hora proxima</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestiondeudor_hproxima" name="gestiondeudor_hproxima" placeholder="Fhproxima" class="form-control input-sm timepicker" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <label for="gestiondeudor_observaciones" class="col-sm-1 control-label">Observaciones</label>
            <div class="form-group col-sm-11">
                <textarea id="gestiondeudor_observaciones" name="gestiondeudor_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
            </div>
        </div>

        <table id="browse-factura3-list" class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th width="5%">Numero</th>
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
}@stop
