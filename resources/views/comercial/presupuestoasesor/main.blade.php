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
				                @foreach( App\Models\Base\Tercero::getAsesor() as $key => $value)
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
		                <th width="16%">Categoria</th>
		                <% _.each(meses, function(name, month) { %>
							<th width="7%"><%- name %></th>
						<% }); %>
		            </tr>
		        </thead>
		        <tbody>

		        <% _.each(categorias, function(categoria) { %>
			        <tr>
			        	<th><%- categoria.categoria_nombre %></th>
						<% _.each(meses, function(name, month) { %>
							<td class="padding-custom-grid">
								<input type="text" id="presupuestoasesor_valor_<%- categoria.id %>_<%- month %>" name="presupuestoasesor_valor_<%- categoria.id %>_<%- month %>" class="form-control input-sm" value="<%- !_.isUndefined(categoria.presupuesto[month]) ? categoria.presupuesto[month] : 0 %>" data-currency-precise>
							</td>
						<% }); %>
			        </tr>
			    <% }); %>
		        </tbody>
		    </table>
		</div>
	</script>
@stop