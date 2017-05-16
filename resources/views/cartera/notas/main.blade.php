@extends('layout.layout')

@section('title') Notas @stop

@section('content')
    <section class="content-header">
        <h1>
            Notas <small>Administración de notas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-nota-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-nota" data-toggle="validator"> 
                <div class="row"> 
                    <label for="nota1_sucursal" class="col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-md-3">
                        <select name="nota1_sucursal" id="nota1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-field="nota1_numero" data-document ="notas" data-wrapper="nota1-create" required>
                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- nota1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <label for="nota1_numero" class="col-md-1 control-label">Número</label>
                    <div class="form-group col-md-1">     
                        <input id="nota1_numero" name="nota1_numero" class="form-control input-sm" type="number" min="1" value="<%- nota1_numero %>" required readonly>
                    </div>
                    
                    <label for="nota1_fecha" class="col-md-1 control-label">Fecha</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="nota1_fecha" name="nota1_fecha" class="form-control input-sm datepicker" value="<%- nota1_fecha %>">
                    </div> 
                </div>
                <div class="row">
                    <label for="nota1_tercero" class="col-md-1 control-label">Cliente</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="nota1_tercero" data-concepto="nota1_conceptonota" data-wrap="wrapper-detalle">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="nota1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="nota1_tercero" type="text" maxlength="15" data-wrapper="nota1-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-10">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="nota1_observaciones" class="col-md-1 control-label">Observaciones</label>
                    <div class="form-group col-md-8">
                        <textarea id="nota1_observaciones" name="nota1_observaciones" class="form-control" rows="2" placeholder="Observaciones ..."><%- nota1_observaciones %></textarea>
                    </div>
                </div>
                <div class="row">
                    <label for="nota1_conceptonota" class="col-md-1 control-label">Concepto</label>
                    <div class="form-group col-md-4 col-xs-10">
                        <select name="nota1_conceptonota" id="nota1_conceptonota" class="form-control select2-default change-concepto" required disabled>
                            @foreach( App\Models\Cartera\ConceptoNota::getConcepto() as $key => $value)
                                <option value="{{ $key }}" <%- nota1_conceptonota == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
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
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-nota">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>

        <div class="box box-success" id="wrapper-detalle" hidden><br>
            <div class="box-body">
                <!-- table table-bordered table-striped --><br>
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5px"></th>
                                <th width="95px">Concepto</th>
                                <th width="95px">Documento</th>
                                <th width="95px">Numero</th>
                                <th width="95px">Cuota</th>
                                <th width="95px">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                                {{-- Render content recibo2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <th class="text-left">Total</td>
                                <th class="text-right"  id="total">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-detalle-nota-tpl">
        <%if(edit){ %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-nota-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
            
        <td><%- conceptonota_nombre %></td>
        <td><%- documentos_nombre %></td>
        <td><%- factura1_numero %></td>
        <td><%- factura3_cuota %></td>
        <td class="text-right"><%- window.Misc.currency( factura3_valor )  %></td>
    </script>
@stop