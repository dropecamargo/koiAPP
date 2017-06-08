@extends('layout.layout')

@section('title') Recibos @stop

@section('content')
    <section class="content-header">
        <h1>
            Recibos <small>Administración de recibos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-recibo-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-recibo1" data-toggle="validator"> 
                <div class="row"> 
                    <label for="recibo1_sucursal" class="col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-md-3">
                        <select name="recibo1_sucursal" id="recibo1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-field="recibo1_numero" data-document ="recibos" data-wrapper="recibo1-create" required>
                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- recibo1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <label for="recibo1_numero" class="col-md-1 control-label">Número</label>
                    <div class="form-group col-md-1">     
                        <input id="recibo1_numero" name="recibo1_numero" class="form-control input-sm" type="number" min="1" value="<%- recibo1_numero %>" required readonly>
                    </div>
                    
                    <label for="recibo1_fecha" class="col-md-1 control-label">Fecha</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="recibo1_fecha" name="recibo1_fecha" class="form-control input-sm datepicker" value="<%- recibo1_fecha %>">
                    </div> 
                </div>
                <div class="row">
                    <label for="recibo1_cuentas" class="col-md-1 control-label">Cuentas</label>
                    <div class="form-group col-md-3">
                        <select name="recibo1_cuentas" id="recibo1_cuentas" class="form-control select2-default" required>
                           @foreach( App\Models\Cartera\CuentaBanco::getCuenta() as $key => $value)
                                <option  value="{{ $key }}" <%- recibo1_cuentas == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <label for="recibo1_fecha_pago" class="col-md-offset-2 col-md-1 control-label">Fecha pago</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="recibo1_fecha_pago" name="recibo1_fecha_pago" class="form-control input-sm datepicker" value="<%- recibo1_fecha_pago %>" required>
                    </div>
                </div>
                <div class="row">
                    <label for="recibo1_tercero" class="col-md-1 control-label">Cliente</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="recibo1_tercero" data-concepto="recibo2_conceptosrc" data-wrap="wrapper-recibo2">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="recibo1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="recibo1_tercero" type="text" maxlength="15" data-wrapper="recibos1-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-10">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="recibo1_observaciones" class="col-md-1 control-label">Observaciones</label>
                    <div class="form-group col-md-8">
                        <textarea id="recibo1_observaciones" name="recibo1_observaciones" class="form-control" rows="2" placeholder="Observaciones ..."><%- recibo1_observaciones %></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('recibos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-recibo">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>

        <div class="box box-success" id="wrapper-recibo2" hidden>
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-recibo2" data-toggle="validator"> 
                    <div class="row"> 
                        <label for="recibo2_conceptosrc" class="control-label col-md-1">Concepto</label>
                        <div class="form-group col-md-3">
                            <select name="recibo2_conceptosrc" id="recibo2_conceptosrc" class="form-control select2-default change-concepto" required>
                            @foreach( App\Models\Cartera\Conceptosrc::getConcepto() as $key => $value)
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            </select>
                        </div>
                        <label for="recibo2_naturaleza" class="control-label col-md-1">Naturaleza</label>
                        <div class="form-group col-md-3">
                            <select name="recibo2_naturaleza" id="recibo2_naturaleza" class="form-control input-sm" required>
                            <option  value="">Seleccione</option>
                            @foreach( config('koi.recibos.naturaleza') as $key => $value )
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            </select>
                        </div> 
                        <label for="recibo2_valor" class="control-label col-md-1">Valor</label>
                        <div class="form-group col-md-2">
                            <input type="text" id="recibo2_valor" name="recibo2_valor" class="form-control input-sm" placeholder="Valor" data-currency required>
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
                    <table table id="browse-recibo-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th>Concepto</th>
                                <th>Documento</th>
                                <th>Numero</th>
                                <th>Cuota</th>
                                <th>Naturaleza</th>
                                <th>Valor</th>
                            </tr>
                        </thead>   
                        <tbody>
                            {{-- Render content recibo2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5"></th>
                                <th class="text-left">Total</th>
                                <th class="text-right"  id="total">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <form method="POST" accept-charset="UTF-8" id="form-recibo3" data-toggle="validator"> 
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group col-sm-12">
                                <label for="recibo3_mediopago" class="control-label">Medio de pago</label>
                                    <select name="recibo3_mediopago" id="recibo3_mediopago" class="form-control select2-default change-medio-pago" required>
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
                        <table table id="browse-recibo3-list" class="table table-hover table-bordered" cellspacing="0">
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
                                {{-- Render content recibo3 --}}
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
            </div>
        </div>
    </script>

    <script type="text/template" id="add-recibomedio-tpl" >
        <% if( resp.mediopago_ch == 1 || (resp.mediopago_ch == 0 && resp.mediopago_ef == 0) ){ %>
            <div class="form-group col-sm-4">
                <label for="recibo3_banco_medio" class="control-label">Banco</label>
                <select name="recibo3_banco_medio" id="recibo3_banco_medio" class="form-control select2-default" required>
                    @foreach( App\Models\Cartera\Banco::getBancos() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>    
            <div class="form-group col-sm-3">
                <label class="control-label" for="recibo3_numero_medio">Numero</label>
                <input type="text" name="recibo3_numero_medio" id="recibo3_numero_medio" maxlength="25" class="input-sm form-control" placeholder="Número de cuenta" required>
            </div>
            <div class="form-group col-sm-2">
                <label class="control-label" for="recibo3_vence_medio">Fecha</label>
                <input type="text" name="recibo3_vence_medio" id="recibo3_vence_medio" value="<%- recibo1_fecha %>" class="input-sm form-control datepicker" required>
            </div>
        <% } %>

        <div class="form-group col-sm-2">
            <label class="control-label" for="recibo3_valor">Valor</label>
            <input type="text" name="recibo3_valor" id="recibo3_valor" class="input-sm form-control" data-currency required>
        </div>
        <div class="form-group col-sm-1"><br>
            <button type="submit" class="btn btn-success btn-sm btn-block">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </script>
    <script type="text/template" id="add-recibo-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-recibo-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- conceptosrc_nombre %></td>
        <td><%- documentos_nombre %></td>
        <td><%- !_.isUndefined(factura1_numero) && !_.isNull(factura1_numero) && factura1_numero != '' ? factura1_numero : '' %></td>
        <td><%- !_.isUndefined(factura3_cuota) && !_.isNull(factura3_cuota) && factura3_cuota != '' ? factura3_cuota : '' %></td>
        <td class="text-left"><%- recibo2_naturaleza == 'D' ? 'Debito' : 'Credito' %></td>
        <td class="text-right"><%- !_.isUndefined(factura3_valor) && !_.isNull(factura3_valor) && factura3_valor != '' ? window.Misc.currency( factura3_valor ) : window.Misc.currency( recibo2_valor ) %></td>
    </script>

    <script type="text/template" id="add-recibo3-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-recibo3-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- mediopago %></td>
        <td><%- banco %></td>
        <td><%- recibo3_numero_medio %></td>
        <td><%- recibo3_vence_medio %></td>
        <td><%- window.Misc.currency( recibo3_valor )%></td>
    </script>
@stop