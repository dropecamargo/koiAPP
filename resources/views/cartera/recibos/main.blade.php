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

    <script type="text/template" id="add-recibo1-tpl">
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
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="recibo1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="recibo1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="recibo1_tercero" type="text" maxlength="15" data-wrapper="recibos1-create" data-name="tercero_nombre" data-contacto="btn-add-contact" value="<%- tercero_nit %>" required>
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

        <div class="box box-success" id="wrapper-recibo2"><br>
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-recibo2" data-toggle="validator"> 
                    <div class="row"> 
                        <div class="form-group col-md-3 col-md-offset-2">
                            <label for="recibo2_conceptosrc" class="control-label">Concepto</label>
                            <select name="recibo2_conceptosrc" id="recibo2_conceptosrc" class="form-control select2-default change-concepto" required>
                            @foreach( App\Models\Cartera\Conceptosrc::getConcepto() as $key => $value)
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="recibo2_naturaleza" class="control-label">Naturaleza</label>
                            <select name="recibo2_naturaleza" id="recibo2_naturaleza" class="form-control" required>
                            <option  value="">Seleccione</option>
                            @foreach( config('koi.recibos.naturaleza') as $key => $value )
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            </select>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="recibo2_valor" class="control-label">Valor</label>
                            <input type="text" id="recibo2_valor" name="recibo2_valor" class="form-control" placeholder="Valor" data-currency required>
                        </div>
                        <div class="form-group col-md-1"><br>
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- table table-bordered table-striped --><br>
                <div class="box-body table-responsive no-padding">
                    <table id="browse-recibo-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5px"></th>
                                <th width="95px">Concepto</th>
                                <th width="95px">Documento</th>
                                <th width="95px">Numero</th>
                                <th width="95px">Cuota</th>
                                <th width="95px">Naturaleza</th>
                                <th width="95px">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                                {{-- Render content recibo2 --}}
                        </tbody>
                    </table>
                </div>
            </div>
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
        <td></td>
        <td></td>
        <td></td>
        <td class="text-left"><%- recibo2_naturaleza == 'D' ? 'Debito' : 'Credito' %></td>
        <td class="text-right"><%- window.Misc.currency( recibo2_valor )  %></td>
    </script>
@stop