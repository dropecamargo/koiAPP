@extends('layout.layout')

@section('title') Tipo de ajuste @stop

@section('content')
    <section class="content-header">
		<h1>
			Tipo de ajuste <small>Administración de tipo ajuste</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			@yield('breadcrumb')
		</ol>
    </section>

	<section class="content">
    	@yield('module')
    </section>

    <script type="text/template" id="add-tipoajuste-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-tipoajuste" data-toggle="validator">
        	<div class="row">
        		<div class="form-group col-sm-2">
        			<label for="tipoajuste_sigla" class="control-label">Sigla</label>
        			<input type="text" id="tipoajuste_sigla" name="tipoajuste_sigla" value="<%- tipoajuste_sigla %>" placeholder="Sigla" class="form-control input-sm input-toupper" maxlength="3" required>
        			<div class="help-block with-errors"></div>
        		</div>
        		<div class="form-group col-sm-6">
        			<label for="tipoajuste_nombre" class="control-label">Nombre</label>
        			<input type="text" id="tipoajuste_nombre" name="tipoajuste_nombre" value="<%- tipoajuste_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
        			<div class="help-block with-errors"></div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-2">
        			<label for="tipoajuste_tipo" class="control-label">Tipo</label>
        			<select name="tipoajuste_tipo" id="tipoajuste_tipo" class="form-control select2-default" required>
        				@foreach(config('koi.tipoinventario') as $key => $value)
        					<option value="{{ $key }}" <%- tipoajuste_tipo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
        				@endforeach
        			</select>
        			<div class="help-block with-errors"></div>
        		</div>
        		<div class="col-sm-3"><br>
        			<label class="checkbox-inline" for="tipoajuste_activo">
        				<input type="checkbox" id="tipoajuste_activo" name="tipoajuste_activo" value="tipoajuste_activo" <%- parseInt(tipoajuste_activo) ? 'checked': ''%>> Activo
        			</label>
        		</div>
        	</div>
            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                        <a href="{{ route('tiposajuste.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-sm-2 col-xs-6 text-right">
                        <button type="button" class="btn btn-primary btn-sm btn-block submit-tipoajuste">{{ trans('app.create') }}</button>
                    </div>
                </div>
            </div>
        </form><br>

        <div class="box box-primary">
    		<div class="box-body" id="render-detalle">
    		</div>
    	</div>
    </script>

    <script type="text/template" id="detalle-tipoajuste-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-detalle-tipoajuste" data-toggle="validator">
            <div class="row">
                <label for="tipoproducto" class="col-sm-offset-1 col-sm-2 control-label text-right">Tipo de producto</label>
                <div class="form-group col-sm-6">
        			<select name="tipoproducto" id="tipoproducto" class="form-control select2-default" required>
        				@foreach( App\Models\Inventario\TipoProducto::getTiposProducto() as $key => $value)
        					<option value="{{ $key }}">{{ $value }}</option>
        				@endforeach
        			</select>
        			<div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-sm-1 col-xs-12">
                    <button type="submit" class="btn btn-success btn-sm btn-block">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- table table-bordered table-striped -->
        <div class="table-responsive no-padding">
            <table id="browse-detalle-tipoajuste-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <tr>
                    <th></th>
                    <th>Código</th>
                    <th>Producto</th>
                </tr>
            </table>
        </div>
    </script>

    <script type="text/template" id="add-detalle-tipoajuste-item-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-detalle-tipoajuste-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- tipoproducto_codigo %></td>
        <td><%- tipoproducto_nombre %></td>
    </script>

    <script type="text/template" id="detalle-tipoajuste-delete-confirm-tpl">
        <p>¿Está seguro que desea eliminar el tipo de producto <b><%- tipoproducto_codigo %> - <%- tipoproducto_nombre %></b>?</p>
    </script>
@stop
