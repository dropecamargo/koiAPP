@extends('layout.layout')

@section('title') Egresos @stop

@section('content')
    <section class="content-header">
        <h1>
            Egresos <small>Administración de egresos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-egreso-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-egreso1" data-toggle="validator">
                <div class="row">
                    <label for="egreso1_regional" class="control-label col-md-1">Regional</label>
                    <div class="form-group col-md-3">
                        <select name="egreso1_regional" id="egreso1_regional" class="form-control select2-default-clear change-regional-consecutive-koi-component" data-field="egreso1_numero" data-document ="egreso" data-wrapper="egreso1-create">
                           @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="egreso1_numero" class="control-label col-md-1">Número</label>
                    <div class="form-group col-md-1">
                        <input type="text" id="egreso1_numero" name="egreso1_numero" class="form-control input-sm" required readonly>
                    </div>
                    <label for="egreso1_fecha" class="control-label col-md-1">Fecha</label>
                    <div class="form-group col-md-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="egreso1_fecha" name="egreso1_fecha" class="form-control input-sm datepicker" value="<%- egreso1_fecha %>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="egreso1_tercero" class="col-md-1 control-label">Cliente</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="egreso1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input type="text" id="egreso1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="egreso1_tercero" maxlength="15" data-name="tercero_nombre" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="egreso1_numero_cheque" class="control-label col-md-1">N° cheque</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="egreso1_numero_cheque" name="egreso1_numero_cheque" placeholder="Número cheque" class="form-control input-sm"  maxlength="15" required>
                    </div>
                    <label for="egreso1_fecha_cheque" class="control-label col-md-1">Fecha</label>
                    <div class="form-group col-md-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="egreso1_fecha_cheque" name="egreso1_fecha_cheque" class="form-control input-sm datepicker" value="<%- egreso1_fecha_cheque %>" required>
                        </div>
                    </div>
                    <label for="egreso1_valor_cheque" class="control-label col-md-1">Valor</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="egreso1_valor_cheque" name="egreso1_valor_cheque" class="form-control input-sm"  data-currency required>
                    </div>
                </div>
                <div class="row">
                    <label for="egreso1_cuentas" class="control-label col-md-1">Cuenta</label>
                    <div class="form-group col-md-3">
                        <select name="egreso1_cuentas" id="egreso1_cuentas" class="form-control select2-default-clear" required>
                           @foreach( App\Models\Cartera\CuentaBanco::getCuenta() as $key => $value)
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="egreso1_observaciones" class="col-md-1 control-label">Observaciones</label>
                    <div class="form-group col-md-8">
                        <textarea id="egreso1_observaciones" name="egreso1_observaciones" class="form-control input-sm" rows="2" placeholder="Observaciones egreso"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('egresos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-egreso">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-egreso2" data-toggle="validator">
                    <div class="row">
                        <label for="egreso2_tercero" class="col-md-1 control-label col-md-offset-1">Cliente</label>
                        <div class="form-group col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="egreso2_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input type="text" id="egreso2_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="egreso2_tercero" maxlength="15" data-concepto="egreso2_tipopago" data-name="tercero2_nombre" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <input id="tercero2_nombre" name="tercero2_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <label for="egreso2_tipopago" class="control-label col-md-1 col-md-offset-1">Tipo pago</label>
                        <div class="form-group col-md-3">
                            <select name="egreso2_tipopago" id="egreso2_tipopago" class="form-control select2-default-clear" disabled>
                               @foreach( App\Models\Tesoreria\TipoPago::getTiposPagos() as $key => $value)
                                    <option  value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="egreso2_valor" class="control-label col-md-1">Valor</label>
                        <div class="form-group col-md-2">
                            <input type="text" id="egreso2_valor" name="egreso2_valor" class="form-control input-sm" data-currency>
                        </div>
                        <div class="form-group col-md-1 col-md-offset-1">
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table table id="browse-egreso2-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Render content egreso2 --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </script>
    <script type="text/template" id="add-egreso-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-egreso-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>

        <td><%- tercero2_nombre %></td>
        <td><%- tipopago_nombre %></td>
        <td class="text-right"><%- !_.isUndefined(facturap3_valor) && !_.isNull(facturap3_valor) && facturap3_valor != '' ? window.Misc.currency( facturap3_valor ) : window.Misc.currency( egreso2_valor ) %></td>
    </script>
@stop
