@extends('layout.layout')

@section('title') Anticipos @stop

@section('content')
    <section class="content-header">
        <h1>
            Anticipos <small>Administración de anticipos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>
    <script type="text/template" id="add-anticipos-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-anticipo1" data-toggle="validator">
                <div class="row">
                    <label for="anticipo1_sucursal" class="col-sm-1 col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-2">
                        <select name="anticipo1_sucursal" id="anticipo1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-wrapper="anticipo-create" data-field="anticipo1_numero" data-document ="anticipo">
                            @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- anticipo1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="anticipo1_numero" class="col-sm-1 col-md-1 control-label">Número</label>
                    <div class="form-group col-sm-1 col-md-1">     
                        <input id="anticipo1_numero" name="anticipo1_numero" class="form-control input-sm" type="number" min="1" value="<%- anticipo1_numero %>" required readonly>
                    </div>
                    <label for="anticipo1_fecha" class="col-sm-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">     
                        <input id="anticipo1_fecha" name="anticipo1_fecha" class="form-control input-sm datepicker" type="text" value="<%- anticipo1_fecha %>" required>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_tercero" class="col-md-1 control-label">Cliente</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="anticipo1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="anticipo1_tercero" placeholder="Cliente" class="form-control tercero-koi-component aaa" name="anticipo1_tercero" type="text" maxlength="15" data-wrapper="anticipo-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-10">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_cuentas" class="col-md-1 control-label">Cuenta Banco</label>
                    <div class="form-group col-md-3">
                        <select name="anticipo1_cuentas" id="anticipo1_cuentas" class="form-control select2-default" required>
                           @foreach( App\Models\Cartera\CuentaBanco::getCuenta() as $key => $value)
                                <option  value="{{ $key }}" <%- anticipo1_cuentas == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="anticipo1_valor" class="col-md-1 control-label">Valor</label>
                    <div class="form-group col-md-2">
                        <input type="text" name="anticipo1_valor" id="anticipo1_valor" class="input-sm form-control" data-currency readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_vendedor" class="col-sm-1 col-md-1 control-label">Vendedor</label>
                    <div class="form-group col-sm-4">
                        <select name="anticipo1_vendedor" id="anticipo1_vendedor" class="form-control select2-default">
                            @foreach( App\Models\Base\Tercero::getSellers() as $key => $value)
                            <option  value="{{ $key }}" <%- anticipo1_vendedor == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_observaciones" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-sm-11">
                    <textarea id="anticipo1_observaciones" name="anticipo1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('anticipos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-anticipo1">{{ trans('app.save') }}</button>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <form method="POST" accept-charset="UTF-8" id="form-anticipo2" data-toggle="validator"> 
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group col-sm-12">
                                <label for="anticipo2_mediopago" class="control-label">Medio de pago</label>
                                    <select name="anticipo2_mediopago" id="anticipo2_mediopago" class="form-control select2-default change-medio-pago" required>
                                        @foreach( App\Models\Cartera\MedioPago::getMedioPago() as $key => $value)
                                            <option  value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-10" id="detail-medio-pago">
                                {{--Render tpl medio pago--}}
                            </div>
                        </div>
                    </form>

                    <!-- table table-bordered table-striped -->
                    <div class="box-body table-responsive no-padding">
                        <table table id="browse-anticipo2-list" class="table table-hover table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th width="15%">Medio de pago</th>
                                    <th width="25%">Banco</th>
                                    <th width="25%">Numero</th>
                                    <th width="15%">Fecha</th>
                                    <th width="15%">Valor</th>
                                </tr>
                            </thead>   
                            <tbody>
                                {{-- Render content anticipo2 --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th class="text-left">Total</th>
                                    <th class="text-right"  id="total">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="box box-success">
                    <div class="box-body">
                        <form method="POST" accept-charset="UTF-8" id="form-anticipo3" data-toggle="validator"> 
                            <div class="row"> 
                                <label for="anticipo3_conceptosrc" class="control-label col-md-1">Concepto</label>
                                <div class="form-group col-md-3">
                                    <select name="anticipo3_conceptosrc" id="anticipo3_conceptosrc" class="form-control select2-default" required>
                                        @foreach( App\Models\Cartera\Conceptosrc::getConceptoAnticipo() as $key => $value)
                                            <option  value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="anticipo3_naturaleza" class="control-label col-md-1">Naturaleza</label>
                                <div class="form-group col-md-3">
                                    <select name="anticipo3_naturaleza" id="anticipo3_naturaleza" class="form-control input-sm" required>
                                        <option  value="">Seleccione</option>
                                        @foreach( config('koi.recibos.naturaleza') as $key => $value )
                                            <option  value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <label for="anticipo3_valor" class="control-label col-md-1">Valor</label>
                                <div class="form-group col-md-2">
                                    <input type="text" id="anticipo3_valor" name="anticipo3_valor" class="form-control input-sm" placeholder="Valor" data-currency required>
                                </div>
                                <div class="form-group col-sm-1">
                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- table table-bordered table-striped -->
                        <div class="box-body table-responsive no-padding">
                            <table table id="browse-anticipo3-list" class="table table-hover table-bordered" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th>Concepto</th>
                                        <th>Naturaleza</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    {{-- Render content anticipo3 --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th class="text-left">Total</th>
                                        <th class="text-right"  id="total">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-anticipomedio-tpl" >
        <% if( resp.mediopago_ch == 1 || (resp.mediopago_ch == 0 && resp.mediopago_ef == 0) ){ %>
            <div class="form-group col-sm-4">
                <label for="anticipo2_banco_medio" class="control-label">Banco</label>
                <select name="anticipo2_banco_medio" id="anticipo2_banco_medio" class="form-control select2-default" required>
                    @foreach( App\Models\Cartera\Banco::getBancos() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>    
            <div class="form-group col-sm-3">
                <label class="control-label" for="anticipo2_numero_medio">Numero</label>
                <input type="text" name="anticipo2_numero_medio" id="anticipo2_numero_medio" maxlength="25" class="input-sm form-control" placeholder="Número de cuenta" required>
            </div>
            <div class="form-group col-sm-2">
                <label class="control-label" for="anticipo2_vence_medio">Fecha</label>
                <input type="text" name="anticipo2_vence_medio" id="anticipo2_vence_medio" value="<%- anticipo1_fecha %>" class="input-sm form-control datepicker" required>
            </div>
        <% } %>

        <div class="form-group col-sm-2">
            <label class="control-label" for="anticipo2_valor">Valor</label>
            <input type="text" name="anticipo2_valor" id="anticipo2_valor" class="input-sm form-control" data-currency required>
        </div>
        <div class="form-group col-sm-1"><br>
            <button type="submit" class="btn btn-success btn-sm btn-block">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </script>

    <script type="text/template" id="add-anticipo3-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-anticipo3-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- conceptosrc_nombre %></td>
        <td class="text-left"><%- anticipo3_naturaleza == 'D' ? 'Debito' : 'Credito' %></td>
        <td class="text-right"><%- window.Misc.currency( anticipo3_valor ) %></td>
    </script>

    <script type="text/template" id="add-anticipo2-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-anticipo2-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- mediopago %></td>
        <td><%- banco %></td>
        <td><%- anticipo2_numero_medio %></td>
        <td><%- anticipo2_vence_medio %></td>
        <td><%- window.Misc.currency( anticipo2_valor )%></td>
    </script>
@stop 