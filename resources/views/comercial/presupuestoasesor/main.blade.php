@extends('layout.layout')
@section('title') Presupesto @stop
@section('content')
   	<section class="content-header">
        <h1>
            Presupuesto <small>Administración de presupuestos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
          	<li>Presupuesto</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary" id="presupuestoasesor-create">
            <form method="POST" accept-charset="UTF-8" id="form-presupuestoasesor" data-toggle="validator">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-5 text-left">
                            <label for="presupuestoasesor_asesor" class="control-label">Asesor</label>
                            <select name="presupuestoasesor_asesor" id="presupuestoasesor_asesor" class="form-control select2-default" required>
                                @foreach( App\Models\Base\Tercero::getBusinessAdvisors() as $key => $value)
                                    <option value="{{ $key }}" <%- presupuestoasesor_asesor == '{{ $key }}' ? 'selected': ''%>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-5 text-left">
                           <label for="presupuestoasesor_subcategoria" class="control-label">Sub categoría</label>
                            <select name="presupuestoasesor_subcategoria" id="presupuestoasesor_subcategoria" class="form-control select2-default" required>
                                @foreach( App\Models\Inventario\SubCategoria::getSubCategorias() as $key => $value)
                                    <option value="{{ $key }}" <%- presupuestoasesor_subcategoria == '{{ $key }}' ? 'selected': ''%>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                       	<div class="form-group col-md-2">
                            <label for="presupuestoasesor_ano" class="control-label">Año</label>
                            <select name="presupuestoasesor_ano" id="presupuestoasesor_ano" class="form-control select2-default change-asesor" required>
                                @for($i = config('koi.app.ano'); $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 text-left">
                            <button type="button" class="btn btn-default btn-sm btn-block click-btn-search">{{ trans('app.find') }}</button>
                        </div>
                        <div class="col-md-2 text-left">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                    <div id="render-div-asesor">
                        {{-- Render --}}
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script type="text/template" id="add-presupuesto-tpl">
       	<br>
        <div class="table-responsive">
            <table id="presupuesto-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">Meses</th>
                        <% _.each(regionales, function(regional) { %>
                            <th><%- regional.regional_nombre %></th>
                        <% }); %>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <% _.each(meses, function(name, month) { %>
                        <tr>
                            <th><%- name %></th>
                        <% _.each(regionales, function(regional) { %>
                            <td class="padding-custom-grid">
                                <input type="text" id="presupuestoasesor_valor_<%- month %>_<%- regional.id %>" name="presupuestoasesor_valor_<%- month %>_<%- regional.id %>" class="form-control input-sm change-input-presupuesto" data-mes="<%- month %>" value="<%- !_.isUndefined(regional.presupuesto[month]) ? regional.presupuesto[month] : 0 %>" data-mes="<%- month %>"  data-regional="<%- regional.id %>" data-currency-precise>
                            </td>
                        <% }); %>
                            <th class="text-right" id="presupuestoasesor_total_mes_<%- month %>" ><%- !_.isUndefined(total_mes[month]) ?  window.Misc.currency(total_mes[month]) : window.Misc.currency(0) %></th>
                        </tr>
                    <% }); %>
                   <tr>
                        <th>Total</th>
                        <% _.each(regionales, function(regional) { %>
                            <th id="presupuestoasesor_total_regional_<%- regional.id %>" class="text-right"><%- !_.isUndefined(total_regionales[regional.id]) ?  window.Misc.currency(total_regionales[regional.id]) : window.Misc.currency(0) %></th>
                        <% }); %>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>
@stop
