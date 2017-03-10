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
        <div class="box box-success" id="presupuestoasesor-create">
            <form method="POST" accept-charset="UTF-8" id="form-presupuestoasesor" data-toggle="validator">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-2 text-left">
                           <label for="presupuestoasesor_asesor" class="control-label">Asesor</label>
                            <select name="presupuestoasesor_asesor" id="presupuestoasesor_asesor" class="form-control select2-default change-asesor" required>
                                @foreach( App\Models\Base\Tercero::getBusinessAdvisors() as $key => $value)
                                    <option value="{{ $key }}" <%- presupuestoasesor_asesor == '{{ $key }}' ? 'selected': ''%>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                       	<div class="form-group col-md-2">
                            <label for="presupuestoasesor_ano" class="control-label">Año</label>
                            <select name="presupuestoasesor_ano" id="presupuestoasesor_ano" class="form-control select2-default change-asesor" required>
                                @for($i = config('koi.app.ano'); $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5 text-left">
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
                       <th width="10%">Categoria</th>
                        <% _.each(meses, function(name, month) { %>
                            <th width="7%"><%- name %></th>
                        <% }); %>
                        <th width="6">Total</th>
                    </tr>
                </thead>                

                <tbody>
                    <% _.each(categorias, function(categoria) { %>
                        <tr>
                            <th>
                                <%- categoria.categoria_nombre %>
                            </th>
                            <% _.each(meses, function(name, month) { %>
                                <td class="padding-custom-grid">
                                    <input type="text" id="presupuestoasesor_valor_<%- categoria.id %>_<%- month %>" name="presupuestoasesor_valor_<%- categoria.id %>_<%- month %>" class="form-control input-sm change-input-presupuesto" value="<%- !_.isUndefined(categoria.presupuesto[month]) ? categoria.presupuesto[month] : 0 %>" data-mes="<%- month %>" data-categoria="<%- categoria.id %>" data-currency-precise>
                                </td>
                            <% }); %>
                            <th class="text-right" id="presupuestoasesor_total_categoria_<%- categoria.id %>" ><%- !_.isUndefined(total_categorias[categoria.id]) ?  window.Misc.currency(total_categorias[categoria.id]) : window.Misc.currency(0) %></th>
                        </tr>
                    <% }); %>
                    <tr>
                        <th>Total</th>
                        <% _.each(meses, function(name, month) { %>
                            <th id="presupuestoasesor_total_mes_<%- month %>" class="text-right"><%- !_.isUndefined(total_mes[month]) ?  window.Misc.currency(total_mes[month]) : window.Misc.currency(0) %></th>
                        <% }); %>
                    </tr>
                </tbody>
            </table>
        </div>
 	</script>
@stop