@extends('layout.layout')

@section('title') Deudores @stop

@section('content')
    <section class="content-header">
        <h1>
            Deudores <small>Administración de deudores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>


    <script type="text/template" id="add-contactodeudor-tpl">
        <div class="row">
    		<div class="form-group col-sm-12">
    			<label for="contactodeudor_nombre" class="control-label">Nombres</label>
    			<input type="text" id="contactodeudor_nombre" name="contactodeudor_nombre" value="<%- contactodeudor_nombre %>" placeholder="Nombres" class="form-control input-sm input-toupper" maxlength="200" required>
    			<div class="help-block with-errors"></div>
    		</div>
        </div>

        <div class="row">
        	<div class="form-group col-sm-6">
                <label for="contactodeudor_direccion" class="control-label">Dirección</label>
          		<div class="input-group input-group-sm">
    				<input id="contactodeudor_direccion" value="<%- contactodeudor_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="contactodeudor_direccion" type="text" maxlength="200" required data-nm-name="tcontacto_dir_nomenclatura">
    				<span class="input-group-btn">
    					<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="contactodeudor_direccion">
    						<i class="fa fa-map-signs"></i>
    					</button>
    				</span>
    			</div>
    			<div class="help-block with-errors"></div>
    		</div>

    		<div class="form-group col-sm-6">
    			<label for="contactodeudor_email" class="control-label">Email</label>
    			<input id="contactodeudor_email" value="<%- contactodeudor_email %>" placeholder="Email" class="form-control input-sm" name="contactodeudor_email" type="email" maxlength="200" required>
    			<div class="help-block with-errors"></div>
    		</div>
        </div>

        <div class="row">
    		<div class="form-group col-sm-4">
    			<label for="contactodeudor_cargo" class="control-label">Cargo</label>
    			<input type="text" id="contactodeudor_cargo" name="contactodeudor_cargo" value="<%- contactodeudor_cargo %>" placeholder="Cargos" class="form-control input-sm input-toupper" maxlength="200">
    			<div class="help-block with-errors"></div>
    		</div>

    		<div class="form-group col-sm-4">
    			<label for="contactodeudor_telefono" class="control-label">Teléfono</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-phone"></i>
    				</div>
    				<input id="contactodeudor_telefono" value="<%- contactodeudor_telefono %>" class="form-control input-sm" name="contactodeudor_telefono" type="text" data-inputmask="'mask': '(999) 999-99-99  EXT 999'" data-mask required>
    			</div>
    			<div class="help-block with-errors"></div>
    		</div>

    		<div class="form-group col-sm-4">
    			<label for="contactodeudor_movil" class="control-label">Celular</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-mobile"></i>
    				</div>
    				<input id="contactodeudor_movil" value="<%- contactodeudor_movil %>" class="form-control input-sm" name="contactodeudor_movil" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
    			</div>
    		</div>
    	</div>
    </script>
@stop
