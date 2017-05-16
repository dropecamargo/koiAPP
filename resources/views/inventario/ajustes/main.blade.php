@extends('layout.layout')

@section('title') Ajustes @stop

@section('content')
    <section class="content-header">
        <h1>
            Ajustes <small>Administración de ajustes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>
    <script type="text/template" id="add-ajuste-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-ajustes" data-toggle="validator"> 
                <div class="row"> 
                    <label for="ajuste1_sucursal" class="col-sm-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-3">
                        <select name="ajuste1_sucursal" id="ajuste1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-field="ajuste1_numero" data-document ="ajuste" data-wrapper="ajuste-create">
                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                        <option  value="{{ $key }}" <%- ajuste1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                    <label for="ajuste1_numero" class="col-sm-1 control-label">Número</label>
                    <div class="form-group col-sm-1">     
                        <input id="ajuste1_numero" name="ajuste1_numero" class="form-control input-sm" type="number" min="1" value="<%- ajuste1_numero %>" required readonly>
                    </div>
                </div>
                <div class="row"> 
                    <label for="ajuste1_tipoajuste" class="col-sm-1 control-label">Tipo</label>
                    <div class="form-group col-sm-3">
                        <select name="ajuste1_tipoajuste" id="ajuste1_tipoajuste" class="form-control select2-default change-in-or-exit-koi-component">
                        @foreach( App\Models\Inventario\TipoAjuste::getTiposAjustes() as $key => $value)
                        <option  value="{{ $key }}" <%- ajuste1_tipoajuste == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div id="ajuste1_lotes">
                        <label for="ajuste1_lote" class="col-sm-1 control-label">Lote</label>
                        <div class="form-group col-sm-2">
                            <input type="text" id="ajuste1_lote" name="ajuste1_lote" placeholder="Lote" class="input-toupper form-control" value="" required>
                        </div> 
                        
                    </div>
                    <label for="ajuste1_fecha" class="col-sm-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">
                        <input type="text" id="ajuste1_fecha" name="ajuste1_fecha" class="form-control input-sm datepicker" value="<%- ajuste1_fecha %>" required>
                    </div>
                </div>
                <div class="row">
                    <label for="ajuste1_observaciones" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-md-10">
                        <textarea id="ajuste1_observaciones" name="ajuste1_observaciones" class="form-control" rows="2" placeholder="Observaciones Ajustes"><%- ajuste1_observaciones %></textarea>
                    </div>
                </div>
          
            </form>           
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('ajustes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-ajuste">{{ trans('app.save') }}</button>
                </div>
            </div>
            <br>    
            <div id="detalle-ajuste">
                <!-- Render detailt -->
            </div>
            <div class="table-responsive no-padding">
                <table id="browse-detalle-ajuste-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="10%">Referencia</th>
                            <th width="30%" align="left">Nombre</th>
                            <th width="15%">Cant. Entrada</th>
                            <th width="15%">Cant. Salida</th>
                            <th width="15%">Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Render content detalle ajuste --}}
                    </tbody>
                </table>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-ajustedetalle-item-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detalleajuste-remove" data-resource = "<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>
        <% if(!edit){ %>
            <td><%- lote_nombre %></td>
       <% } %>

        <td><%-(ajuste2_cantidad_entrada <= 0) ? '0' : ajuste2_cantidad_entrada %></td>
        <td><%- (ajuste2_cantidad_salida <= 0) ? '0' : ajuste2_cantidad_salida %></td>
        <td><%- window.Misc.currency(ajuste2_costo) %></td>
    </script>

    <script type="text/template" id="add-detailt-ajuste-tpl">
        <div class="box-body box-success">
            <form method="POST" accept-charset="UTF-8" id="form-detalle-ajuste" data-toggle="validator">
                <div class="row">
                    <div class="form-group col-sm-2 col-md-offset-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_serie">
                                    <i class="fa fa-barcode"></i>
                                </button>
                            </span>
                            <input id="producto_serie" placeholder="Serie" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="ajuste-create" data-office= "ajuste1_sucursal" data-name="producto_nombre" required <%- tipoajuste_tipo=='S' ? 'data-costo=ajuste2_costo': '' %> <%- tipoajuste_tipo=='S' ?  'data-ref=false' : 'data-ref=true' %>> 
                        </div>
                    </div>
                    <div class="col-sm-5 ">
                        <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                    </div>

                </div>
                <div class="row">
                    <% if(tipoajuste_tipo == 'R' || tipoajuste_tipo == 'E') { %>
                        <div id="ajuste2_cantidad_entradas" class="col-md-1 col-md-offset-2">
                        <label for="ajuste2_cantidad_entrada" class="control-label">Cantidad Entrada</label>
                            <input id="ajuste2_cantidad_entrada" name="ajuste2_cantidad_entrada" min="1" class="form-control input-sm <%- tipoajuste_tipo == 'R' ? 'koi-changed-reclacification':'' %>" type="number" required>
                        </div>
                    <% } %>

                    <% if(tipoajuste_tipo == 'R' || tipoajuste_tipo == 'S'){ %>
                        <div id="ajuste2_cantidad_salidas" class="col-md-1 col-md-offset-2">
                         <label for="ajuste2_cantidad_salida" class="control-label">Cantidad Salida</label>
                            <input id="ajuste2_cantidad_salida" name="ajuste2_cantidad_salida"  class="form-control input-sm  <%- tipoajuste_tipo == 'R' ? 'koi-changed-reclacification':'' %>" type="number" min="1" required>
                        </div>
                    <% } %>
                    <div id="ajuste2_costos" class="col-md-2 col-md-offset-2">
                    <label for="ajuste2_costo" class="control-label">Costo</label>
                        <input id="ajuste2_costo" name="ajuste2_costo" class="form-control input-sm" type="text" data-currency required <%- tipoajuste_tipo=='S' ? 'readonly': '' %> >
                    </div>
                    <br>
                    <div class="form-group col-sm-1 col-md-offset-1">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </script>
@stop