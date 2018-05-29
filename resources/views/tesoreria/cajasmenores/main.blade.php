@extends('layout.layout')

@section('title') Caja Menor @stop

@section('content')
    <section class="content-header">
        <h1>
            Caja menor <small>Administración de caja menor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-cajamenor-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-cajamenor" data-toggle="validator">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cajamenor1_regional" class="control-label">Regional</label>
                    <select name="cajamenor1_regional" id="cajamenor1_regional" class="form-control select2-default-clear change-regional-consecutive-koi-component" data-field="cajamenor1_numero" data-document ="cajamenor" data-wrapper="cajamenor-create" required>
                        @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                            <option  value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label for="cajamenor1_numero" class="control-label">Número</label>
                    <input id="cajamenor1_numero" name="cajamenor1_numero" class="form-control input-sm" type="number" min="1" value="<%- cajamenor1_numero %>" required readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="cajamenor1_fecha" class="control-label">Fecha</label>
                    <input id="cajamenor1_fecha" name="cajamenor1_fecha" class="form-control input-sm datepicker-back" type="text"  value="{{ date('Y-m-d') }}" placeholder="Fecha" date-picker  required>
                </div>

                <div class="form-group col-md-2">
                    <label for="cajamenor1_efectivo" class="control-label">Efectivo</label>
                    <input type="text" id="cajamenor1_efectivo" name="cajamenor1_efectivo" class="form-control input-sm" data-currency required>
                </div>
                <div class="form-group col-md-2">
                    <label for="cajamenor1_provisionales" class="control-label">Provisionales</label>
                    <input  type="text" id="cajamenor1_provisionales" name="cajamenor1_provisionales" class="form-control input-sm"  value="" data-currency  required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="cajamenor1_tercero" class="control-label">Empleado</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="cajamenor1_tercero">
                                <i class="fa fa-user"></i>
                            </button>
                        </span>
                        <input id="cajamenor1_tercero" placeholder="Empleado" class="form-control tercero-koi-component" name="cajamenor1_tercero" type="text" maxlength="15" data-wrapper="cajamenor-create" data-name="empleado_nombre" required>
                    </div>
                </div>
                <div class="form-group col-md-5 col-xs-12">
                    <label for="cajamenor1_tercero" class="control-label"></label>
                    <input id="empleado_nombre" name="empleado_nombre" placeholder="Nombre empleado" class="form-control input-sm" type="text" maxlength="15" readonly required>
                </div>
                <div class="form-group col-md-2">
                    <label for="cajamenor1_reembolso" class="control-label">Reembolso</label>
                    <input type="text" id="cajamenor1_reembolso" name="cajamenor1_reembolso" class="form-control input-sm"   data-currency required>
                </div>
                <div class="form-group col-md-2">
                    <label for="cajamenor1_fondo" class="control-label">Fondo</label>
                    <input type="text" id="cajamenor1_fondo" name="cajamenor1_fondo" class="form-control input-sm" data-currency required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="cajamenor1_observaciones" class="control-label">Observaciones</label>
                    <textarea id="cajamenor1_observaciones" name="cajamenor1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                </div>
            </div>
        </form>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href="{{ route('ajustesc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-cajamenor">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>

        <div id="render-form-detail"></div>
    </script>

    <script type="text/template" id="add-cajamenor-detail-tpl">
        <div class="box box-solid">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-detail-cajamenor" data-toggle="validator">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="cajamenor2_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="cajamenor2_tercero" placeholder="Tercero" class="form-control tercero-koi-component" name="cajamenor2_tercero" type="text" maxlength="15" data-wrapper="cajamenor-create" data-name="tercero_nombre" required>
                            </div>
                        </div>
                        <div class="form-group col-md-5 col-xs-12">
                            <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre tercero" class="form-control input-sm" type="text" maxlength="15" readonly required>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="cajamenor2_conceptocajamenor" id="cajamenor2_conceptocajamenor" class="form-control select2-default-clear"data-placeholder="Seleccione concepto" required>
                                @foreach( App\Models\Tesoreria\ConceptoCajaMenor::getConceptsCajaMenor() as $key => $value)
                                    <option  value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <select name="cajamenor2_cuenta" id="cajamenor2_cuenta" class="form-control select2-default-clear"  data-placeholder="Seleccione plan de cuentas">
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <select name="cajamenor2_centrocosto" id="cajamenor2_centrocosto" class="form-control select2-default-clear"  data-placeholder="Seleccione centro de costo">
                                @foreach( App\Models\Contabilidad\CentroCosto::getCentrosCosto() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2 ">
                            <label for="cajamenor2_subtotal" class="control-label">Subtotal</label>
                            <input type="text" id="cajamenor2_subtotal" name="cajamenor2_subtotal" class="form-control input-sm"   data-currency required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cajamenor2_iva" class="control-label">Iva</label>
                            <input type="text" id="cajamenor2_iva" name="cajamenor2_iva" class="form-control input-sm" data-currency required>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="cajamenor2_reteiva" class="control-label">Rete iva</label>
                            <input type="text" id="cajamenor2_reteiva" name="cajamenor2_reteiva" class="form-control input-sm"   data-currency required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cajamenor2_reteica" class="control-label">Rete Ica</label>
                            <input type="text" id="cajamenor2_reteica" name="cajamenor2_reteica" class="form-control input-sm"   data-currency required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cajamenor2_retefuente" class="control-label">Rete Fuente</label>
                            <input type="text" id="cajamenor2_retefuente" name="cajamenor2_retefuente" class="form-control input-sm" data-currency required>
                        </div><br>
                        <div class="form-group col-md-1">
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-cajamenor-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="25%">Concepto</th>
                                <th width="30%">Tercero</th>
                                <th width="15%">Cuenta</th>
                                <th width="15%">Centro Costo</th>
                                <th width="10%">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                                {{-- Render content ajustep2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total</td>
                                <th class="text-right"  id="total-valor">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-detalle-cajamenor-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detalle-cajamenor-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- conceptocajamenor_nombre %></td>
        <td><%- tercero_nombre %></td>
        <td>
            <a href="<%- window.Misc.urlFull( Route.route('plancuentas.show', {plancuentas: cajamenor2_cuenta}) ) %>" title="<%- plancuentas_nombre %>" target="_blank">
                <%- plancuentas_cuenta %>
            </a>
        </td>
        <td>
            <a href="<%- window.Misc.urlFull( Route.route('centroscosto.show', {centroscosto: cajamenor2_centrocosto}) ) %>" title="<%- centrocosto_nombre %>" target="_blank">
                <%- centrocosto_codigo %>
            </a>
        </td>
        <td>0</td>
    </script>
@stop
