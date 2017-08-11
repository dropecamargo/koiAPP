@extends('layout.layout')

@section('title') Ajustes proveedor @stop

@section('content')
    <section class="content-header">
        <h1>
            Ajustes proveedor <small>Administración de proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-ajustep-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-ajustep" data-toggle="validator"> 
                <div class="row"> 
                    <label for="ajustep1_regional" class="col-md-1 control-label">Regional</label>
                    <div class="form-group col-md-3">
                        <select name="ajustep1_regional" id="ajustep1_regional" class="form-control select2-default-clear change-regional-consecutive-koi-component" data-field="ajustep1_numero" data-document ="ajustep" data-wrapper="ajustep-create" required>
                        @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                            <option  value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <label for="ajustep1_numero" class="col-md-1 control-label">Número</label>
                    <div class="form-group col-md-1">     
                        <input id="ajustep1_numero" name="ajustep1_numero" class="form-control input-sm" type="number" min="1" value="<%- ajustep1_numero %>" required readonly>
                    </div>

                    <label for="ajustep1_conceptoajustep" class="col-md-1 control-label">Concepto</label>
                    <div class="form-group col-md-3">
                        <select name="ajustep1_conceptoajustep" id="ajustep1_conceptoajustep" class="form-control select2-default-clear">
                        @foreach( App\Models\Tesoreria\ConceptoAjustep::getConceptoAjustep() as $key => $value)
                            <option  value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ajustep1_tercero" class="col-md-1 control-label">Tercero</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="ajustep1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="ajustep1_tercero" placeholder="Tercero" class="form-control tercero-koi-component" name="ajustep1_tercero" type="text" maxlength="15" data-wrapper="ajustep-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-10">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre tercero" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="ajustep1_observaciones" class="col-md-1 control-label">Observaciones</label>
                    <div class="form-group col-md-9">
                        <textarea id="ajustep1_observaciones" name="ajustep1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('ajustesc.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-ajustep">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div><br>

        <div id="render-form-detail"></div>
    </script>

    <script type="text/template" id="add-detail-tpl">
        <div class="box box-success">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-detail-ajustep" data-toggle="validator"> 
                    <div class="row">
                        <label for="ajustep2_tercero" class="col-md-offset-1 col-md-1 control-label">Tercero</label>
                        <div class="form-group col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="ajustep2_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="ajustep2_tercero" placeholder="Tercero" class="form-control tercero-koi-component" name="ajustep2_tercero" data-concepto="ajustep2_documentos_doc" type="text" maxlength="15" data-name="terceroc_nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-10">
                            <input id="terceroc_nombre" name="terceroc_nombre" placeholder="Nombre tercero" class="form-control input-sm" type="text" maxlength="15" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <label for="ajustep2_documentos_doc" class="col-md-1 control-label">Documento</label>
                        <div class="form-group col-md-3">
                            <select name="ajustep2_documentos_doc" id="ajustep2_documentos_doc" class="form-control select2-default-clear change-documento-treasury" required disabled>
                            @foreach( App\Models\Base\Documentos::getDocumentos() as $key => $value)
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            </select>
                        </div>

                        <label for="ajustep2_naturaleza" class="col-md-1 control-label">Naturaleza</label>
                        <div class="form-group col-md-2">
                            <select name="ajustep2_naturaleza" id="ajustep2_naturaleza" class="form-control" required>
                                <option  value="">Seleccione</option>
                                @foreach( config('koi.recibos.naturaleza') as $key => $value )
                                    <option  value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="ajustep2_valor" class="col-md-1 control-label">Valor</label>
                        <div class="form-group col-md-2">
                            <input type="text" id="ajustep2_valor" name="ajustep2_valor" class="form-control" placeholder="Valor" data-currency required>
                        </div>
                        <div class="form-group col-md-offset-1 col-md-1">
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-ajustep-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <td colspan="5"></td>
                                <th colspan="2" class="text-center">Naturaleza</th>
                            </tr>
                            <tr>
                                <th width="5px"></th>
                                <th width="95px">Tercero</th>
                                <th width="95px">Documento</th>
                                <th width="95px">Numero</th>
                                <th width="95px">Cuota</th>
                                <th width="95px">Debito</th>
                                <th width="95px">Credito</th>
                            </tr>
                        </thead>
                        <tbody>
                                {{-- Render content ajustep2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <th class="text-left">Total</td>
                                <th class="text-right"  id="total-debito">0</td>
                                <th class="text-right"  id="total-credito">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-detalle-ajustep-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detalleajustep-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- tercero_nombre %></td>
        <td><%- documentos_nombre %></td>
        <td><%- facturap1_numero %></td>
        <td><%- facturap3_cuota %></td>
        <td class="text-right"><%- window.Misc.currency( ajustep2_naturaleza == 'D' ? (!_.isUndefined(facturap3_valor) && !_.isNull(facturap3_valor) && facturap3_valor != '' ? facturap3_valor : ajustep2_valor) : 0 ) %></td>
        <td class="text-right"><%- window.Misc.currency( ajustep2_naturaleza == 'C' ? (!_.isUndefined(facturap3_valor) && !_.isNull(facturap3_valor) && facturap3_valor != '' ? facturap3_valor : ajustep2_valor) : 0 ) %></td>
    </script>

    <script type="text/template" id="add-ajustep-factura-tpl">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-factura-cuota-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <td colspan="6"></td>
                                <th colspan="2" class="text-center">Naturaleza</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Fecha</th>
                                <th>Vencimiento</th>
                                <th>Numero</th>
                                <th>Cuota</th>
                                <th>Saldo</th>
                                <th><small>Debito</small></th>
                                <th><small>Credito</small></th>
                                <th>A pagar</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Render content --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-item-ajustep-tpl">
        <% if( facturap3_facturap1 == '' ) { %>
            <th colspan="9" class="text-center">NO EXISTEN FACTURAS DE ESTE PROVEEDOR</th>
        <% }else{ %>
            <td><input type="checkbox" id="check_<%- id %>" name="check_<%- id %>" class="change-check"></td>
            <td><%- moment(facturap1_fecha).format('YYYY-MM-DD') %></td>
            <td><%- facturap3_vencimiento %></td>
            <td><%- facturap1_numero %></td>
            <td><%- facturap3_cuota %></td>
            <td><%- window.Misc.currency(facturap3_saldo) %></td>
            <td><input type="checkbox" id="debito_<%- id %>" name="debito_<%- id %>" class="change-naturaleza"></td>
            <td><input type="checkbox" id="credito_<%- id %>" name="credito_<%- id %>" class="change-naturaleza"></td>
            <td><input type="text" id="pagar_<%- id %>" name="pagar_<%- id %>" class="form-control input-sm change-pagar" data-currency-negative></td>
        <% } %>
    </script>
@stop