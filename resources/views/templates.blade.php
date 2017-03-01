{{-- Js templates --}}

{{--Administrativo--}}
{{--template Actividad--}}
<script type="text/template" id="add-actividad-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="actividad_codigo" class="control-label">Código</label>
			<input type="text" id="actividad_codigo" name="actividad_codigo" value="<%- actividad_codigo %>" placeholder="Código" class="form-control input-sm input-toupper" maxlength="11" required>
		</div>
		<div class="form-group col-md-8">
			<label for="actividad_nombre" class="control-label">Nombre</label>
			<input type="text" id="actividad_nombre" name="actividad_nombre" value="<%- actividad_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" required>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-md-2">
			<label for="actividad_tarifa" class="control-label">% Cree</label>
			<input type="text" id="actividad_tarifa" name="actividad_tarifa" value="<%- actividad_tarifa %>" placeholder="% Cree" class="form-control input-sm spinner-percentage" maxlength="4" required>
		</div>
    	<div class="form-group col-md-2">
			<label for="actividad_categoria" class="control-label">Categoria</label>
			<input type="text" id="actividad_categoria" name="actividad_categoria" value="<%- actividad_categoria %>" placeholder="Categoria" class="form-control input-sm input-toupper" maxlength="3">
		</div>
	</div>
</script>




{{-- Documentos --}}
<script type="text/template" id="add-documentos-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="documentos_codigo" class="control-label">Código</label>
			<input type="text" id="documentos_codigo" name="documentos_codigo" value="<%- documentos_codigo %>" placeholder="Código" class="form-control input-sm input-toupper" maxlength="4" required>
		</div>
		<div class="form-group col-md-4">
			<label for="documentos_nombre" class="control-label">Nombre</label>
			<input type="text" id="documentos_nombre" name="documentos_nombre" value="<%- documentos_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
    </div>
</script>

{{-- Tipo Actividad --}}
<script type="text/template" id="add-tipoactividad-tpl">
    <div class="row">
		<div class="col-md-4 col-md-offset-4 text-left">
			<label for="tipoactividad_nombre" class="control-label">Nombre</label>
			<input type="text" id="tipoactividad_nombre" name="tipoactividad_nombre" value="<%- tipoactividad_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
	</div>
	<br>
	<div class="row">
    	<div class="col-md-1 col-md-offset-4 text-left">
	    	<label class="checkbox-inline" for="tipoactividad_activo">
				<input type="checkbox" id="tipoactividad_activo" name="tipoactividad_activo" value="tipoactividad_activo" <%- parseInt(tipoactividad_activo) ? 'checked': ''%>> Activo
			</label>
		</div>

		<div class="form-group col-md-1">
			<label class="checkbox-inline" for="tipoactividad_comercial">
				<input type="checkbox" id="tipoactividad_comercial" name="tipoactividad_comercial" value="tipoactividad_comercial" <%- parseInt(tipoactividad_comercial) ? 'checked': ''%>> Comercio
			</label>
		</div>

		<div class="form-group col-md-1">
			<label class="checkbox-inline" for="tipoactividad_tecnico">
				<input type="checkbox" id="tipoactividad_tecnico" name="tipoactividad_tecnico" value="tipoactividad_tecnico" <%- parseInt(tipoactividad_tecnico) ? 'checked': ''%>> Tecnico
			</label>
		</div>

		<div class="form-group col-md-1">
			<label class="checkbox-inline" for="tipoactividad_cartera">
				<input type="checkbox" id="tipoactividad_cartera" name="tipoactividad_cartera" value="tipoactividad_cartera" <%- parseInt(tipoactividad_cartera) ? 'checked': ''%>> Cartera
			</label>
		</div>
	</div>
</script>

{{--template punto de venta--}}
<script type="text/template" id="add-puntoventa-tpl">
    <div class="row">
		<div class="form-group col-md-6">
			<label for="puntoventa_nombre" class="control-label">Nombre</label>
			<input type="text" id="puntoventa_nombre" name="puntoventa_nombre" value="<%- puntoventa_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-2">
			<label for="puntoventa_prefijo" class="control-label">Prefijo</label>
			<input type="text" id="puntoventa_prefijo" name="puntoventa_prefijo" value="<%- puntoventa_prefijo %>" placeholder="Prefijo" class="form-control input-sm input-toupper" maxlength="4">
		</div>

		<div class="form-group col-md-4">
			<label for="puntoventa_resolucion_dian" class="control-label">Resolución de facturación DIAN</label>
			<input type="text" id="puntoventa_resolucion_dian" name="puntoventa_resolucion_dian" value="<%- puntoventa_resolucion_dian %>" placeholder="Resolución de facturación DIAN" class="form-control input-sm input-toupper" maxlength="200">
		</div>
    </div>
</script>

{{--template Tercero--}}
<script type="text/template" id="add-tercero-tpl">
	<div class="row">
		<div class="form-group col-md-3">
			<label for="tercero_nit" class="control-label">Documento</label>
			<div class="row">
				<div class="col-md-9">
					<input id="tercero_nit" value="<%- tercero_nit %>" placeholder="Nit" class="form-control input-sm change-nit-koi-component" name="tercero_nit" type="text" required data-field="tercero_digito" maxlength="10" >
				</div>
				<div class="col-md-3">
					<input id="tercero_digito" value="<%- tercero_digito %>" class="form-control input-sm" name="tercero_digito" type="text" readonly required>
				</div>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_tipo" class="control-label">Tipo</label>
			<select name="tercero_tipo" id="tercero_tipo" class="form-control" required>
				<option value="" selected>Seleccione</option>
				@foreach( config('koi.terceros.tipo') as $key => $value)
					<option value="{{ $key }}" <%- tercero_tipo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_persona" class="control-label">Persona</label>
			<select name="tercero_persona" id="tercero_persona" class="form-control" required>
				<option value="" selected>Seleccione</option>
				@foreach( config('koi.terceros.persona') as $key => $value)
					<option value="{{ $key }}" <%- tercero_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_regimen" class="control-label">Regimen</label>
			<select name="tercero_regimen" id="tercero_regimen" class="form-control" required>
				<option value="" selected>Seleccione</option>
				@foreach( config('koi.terceros.regimen') as $key => $value)
					<option value="{{ $key }}" <%- tercero_regimen == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-3">
			<label for="tercero_nombre1" class="control-label">1er. Nombre</label>
			<input id="tercero_nombre1" value="<%- tercero_nombre1 %>" placeholder="1er. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre1" type="text">
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_nombre2" class="control-label">2do. Nombre</label>
			<input id="tercero_nombre2" value="<%- tercero_nombre2 %>" placeholder="2do. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre2" type="text">
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_apellido1" class="control-label">1er. Apellido</label>
			<input id="tercero_apellido1" value="<%- tercero_apellido1 %>" placeholder="1er. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido1" type="text">
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_apellido2" class="control-label">2do. Apellido</label>
			<input id="tercero_apellido2" value="<%- tercero_apellido2 %>" placeholder="2do. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido2" type="text">
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-12">
			<label for="tercero_razonsocial" class="control-label">Razón Social, Comercial o Establecimiento</label>
			<input id="tercero_razonsocial" value="<%- tercero_razonsocial %>" placeholder="Razón Social, Comercial o Establecimiento" class="form-control input-sm input-toupper" name="tercero_razonsocial" type="text">
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-3">
			<label for="tercero_direccion" class="control-label">Dirección</label>
      		<div class="input-group input-group-sm">
				<input id="tercero_direccion" value="<%- tercero_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="tercero_direccion" type="text" required>
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tercero_direccion">
						<i class="fa fa-map-signs"></i>
					</button>
				</span>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_municipio" class="control-label">Municipio</label>
			<select name="tercero_municipio" id="tercero_municipio" class="form-control select2-default" required>
				@foreach( App\Models\Base\Municipio::getMunicipios() as $key => $value)
					<option value="{{ $key }}" <%- tercero_municipio == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_email" class="control-label">Email</label>
			<input id="tercero_email" value="<%- tercero_email %>" placeholder="Email" class="form-control input-sm" name="tercero_email" type="email">
		    <div class="help-block with-errors"></div>
		</div>
    </div>

    <div class="row">
    	<div class="form-group col-md-3">
			<label for="tercero_telefono1" class="control-label">Teléfono</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-phone"></i>
				</div>
				<input id="tercero_telefono1" value="<%- tercero_telefono1 %>" class="form-control input-sm" name="tercero_telefono1" type="text" data-inputmask="'mask': '(+99) 999-99-99'" data-mask>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_telefono2" class="control-label">2do. Teléfono</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-phone"></i>
				</div>
				<input id="tercero_telefono2" value="<%- tercero_telefono2 %>" class="form-control input-sm" name="tercero_telefono2" type="text" data-inputmask="'mask': '(+99) 999-99-99'" data-mask>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_fax" class="control-label">Fax</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-fax"></i>
				</div>
				<input id="tercero_fax" value="<%- tercero_fax %>" class="form-control input-sm" name="tercero_fax" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_celular" class="control-label">Celular</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-mobile"></i>
				</div>
				<input id="tercero_celular" value="<%- tercero_celular %>" class="form-control input-sm" name="tercero_celular" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="form-group col-md-6">
			<label for="tercero_representante" class="control-label">Representante Legal</label>
			<input id="tercero_representante" value="<%- tercero_representante %>" placeholder="Representante Legal" class="form-control input-sm input-toupper" name="tercero_representante" type="text" maxlength="200">
		</div>
		<div class="form-group col-md-3">
    		<label for="tercero_cc_representante" class="control-label">Cédula</label>
    		<input id="tercero_cc_representante" value="<%- tercero_cc_representante %>" placeholder="Cédula" class="form-control input-sm" name="tercero_cc_representante" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
    	</div>
	</div>

    <div class="row">
    	<div class="form-group col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
						<li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
					<% } %>
				</ul>
				<div class="tab-content">

					{{-- Tab contabilidad --}}
					<div class="tab-pane active" id="tab_contabilidad">
	    	    	    <div class="row">
						    <div class="form-group col-md-10">
						    		<label for="tercero_actividad" class="control-label">Actividad Económica</label>
						    		<select name="tercero_actividad" id="tercero_actividad" class="form-control select2-default change-actividad-koi-component" required data-field="tercero_retecree">
										@foreach( App\Models\Base\Actividad::getActividades() as $key => $value)
											<option value="{{ $key }}" <%- tercero_actividad == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
										@endforeach
									</select>
					    	</div>
					    	<div class="form-group col-md-2">
					    		<label for="tercero_retecree" class="control-label">% Cree</label>
					    		<div id="tercero_retecree"><%- actividad_tarifa %></div>
					    	</div>
					    </div>

					    <div class="row">
					    	<div class="form-group col-md-2">
						    	<label class="checkbox-inline" for="tercero_activo">
									<input type="checkbox" id="tercero_activo" name="tercero_activo" value="tercero_activo" <%- parseInt(tercero_activo) ? 'checked': ''%>> Activo
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_cliente">
									<input type="checkbox" id="tercero_cliente" name="tercero_cliente" value="tercero_cliente" <%- parseInt(tercero_socio) ? 'checked': ''%>> Cliente
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_acreedor">
									<input type="checkbox" id="tercero_acreedor" name="tercero_acreedor" value="tercero_acreedor" <%- parseInt(tercero_acreedor) ? 'checked': ''%>> Acreedor
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_interno">
									<input type="checkbox" id="tercero_interno" name="tercero_interno" value="tercero_interno" <%- parseInt(tercero_interno) ? 'checked': ''%>> Interno
								</label>
							</div>

							<div class="form-group col-md-3">
								<label class="checkbox-inline" for="tercero_responsable_iva">
									<input type="checkbox" id="tercero_responsable_iva" name="tercero_responsable_iva" value="tercero_responsable_iva" <%- parseInt(tercero_responsable_iva) ? 'checked': ''%>> Responsable de IVA
								</label>
							</div>
					    </div>

					    <div class="row">
					    	<div class="form-group col-md-2">
						    	<label class="checkbox-inline" for="tercero_empleado">
									<input type="checkbox" id="tercero_empleado" name="tercero_empleado" value="tercero_empleado" <%- parseInt(tercero_empleado) ? 'checked': ''%>> Empleado
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_proveedor">
									<input type="checkbox" id="tercero_proveedor" name="tercero_proveedor" value="tercero_proveedor" <%- parseInt(tercero_proveedor) ? 'checked': ''%>> Proveedor
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_extranjero">
									<input type="checkbox" id="tercero_extranjero" name="tercero_extranjero" value="tercero_extranjero" <%- parseInt(tercero_extranjero) ? 'checked': ''%>> Extranjero
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_afiliado">
									<input type="checkbox" id="tercero_afiliado" name="tercero_afiliado" value="tercero_afiliado" <%- parseInt(tercero_afiliado) ? 'checked': ''%>> Afiliado
								</label>
							</div>

							<div class="form-group col-md-3">
								<label class="checkbox-inline" for="tercero_autoretenedor_cree">
									<input type="checkbox" id="tercero_autoretenedor_cree" name="tercero_autoretenedor_cree" value="tercero_autoretenedor_cree" <%- parseInt(tercero_autoretenedor_cree) ? 'checked': ''%>> Autorretenedor CREE
								</label>
							</div>
					    </div>

						<div class="row">
							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_socio">
									<input type="checkbox" id="tercero_socio" name="tercero_socio" value="tercero_socio" <%- parseInt(tercero_socio) ? 'checked': ''%>> Socio
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_mandatario">
									<input type="checkbox" id="tercero_mandatario" name="tercero_mandatario" value="tercero_mandatario" <%- parseInt(tercero_mandatario) ? 'checked': ''%>> Mandatario
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_gran_contribuyente">
									<input type="checkbox" id="tercero_gran_contribuyente" name="tercero_gran_contribuyente" value="tercero_gran_contribuyente" <%- parseInt(tercero_gran_contribuyente) ? 'checked': ''%>> Gran contribuyente
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_autoretenedor_renta">
									<input type="checkbox" id="tercero_autoretenedor_renta" name="tercero_autoretenedor_renta" value="tercero_autoretenedor_renta" <%- parseInt(tercero_autoretenedor_renta) ? 'checked': ''%>> Autorretenedor renta
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_autoretenedor_ica">
									<input type="checkbox" id="tercero_autoretenedor_ica" name="tercero_autoretenedor_ica" value="tercero_autoretenedor_ica" <%- parseInt(tercero_autoretenedor_ica) ? 'checked': ''%>> Autorretenedor ICA
								</label>
							</div>
					    </div>

					    <div class="row">
							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_otro">
									<input type="checkbox" id="tercero_otro" name="tercero_otro" value="tercero_otro" <%- parseInt(tercero_otro) ? 'checked': ''%>> Otro
								</label>
							</div>

							<div class="form-group col-md-2">
								<input id="tercero_cual" value="<%- tercero_cual %>" placeholder="¿Cual?" class="form-control input-sm" name="tercero_cual" type="text" maxlength="15">
							</div>
					    </div>
					</div>

					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
						{{-- Tab contactos --}}
						<div class="tab-pane" id="tab_contactos">
						    <div class="row">
						    <!-- div class="row">
								<div class="col-md-offset-4 col-md-4 col-sm-offset-2 col-sm-8 col-xs-12">
									<button type="button" class="btn btn-primary btn-block btn-sm btn-add-tcontacto" data-resource="contacto" data-tercero="<%- id %>">
										<i class="fa fa-user-plus"></i>  Nuevo contacto
									</button>
								</div>
							</div>
							<br / -->
								<div class="box box-success">
									<div class="box-body table-responsive no-padding">
										<table id="browse-contact-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
							            	<thead>
								            	<tr>
								                	<th>Nombre</th>
								                	<th>Dirección</th>
								                	<th>Teléfono</th>
								                	<th>Celular</th>
								            	</tr>
							           		</thead>
							         		<tbody>
												{{-- Render contact list --}}
							           		</tbody>
										</table>
									</div>
								</div>
							</div>

					</div>
					<% } %>
					</div>
				</div>
			</div>
    	</div>
</script>

<script type="text/template" id="contact-item-list-tpl">
	<td><%- tcontacto_nombres %> <%- tcontacto_apellidos %></td>
	<td><%- tcontacto_direccion %></td>
	<td><%- tcontacto_telefono %></td>
	<td><%- tcontacto_celular %></td>
	
	<!-- td class="text-center">
		<a class="btn btn-default btn-xs btn-edit-tcontacto" data-resource="<%- id %>">
			<span><i class="fa fa-pencil-square-o"></i></span>
		</a>
	</td -->
</script>

{{-- Template Contabilidad --}}

{{-- Documento --}}
<script type="text/template" id="add-documento-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="documento_codigo" class="control-label">Código</label>
			<input type="text" id="documento_codigo" name="documento_codigo" value="<%- documento_codigo %>" placeholder="Código" class="form-control input-sm input-toupper" maxlength="20" required>
		</div>
		<div class="form-group col-md-8">
			<label for="documento_nombre" class="control-label">Nombre</label>
			<input type="text" id="documento_nombre" name="documento_nombre" value="<%- documento_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
    </div>
	<div class="row">
		<div class="form-group col-md-6 col-xs-10">
			<label for="documento_folder" class="control-label">Folder</label>
			<select name="documento_folder" id="documento_folder" class="form-control select2-default" required>
				@foreach( App\Models\Contabilidad\Folder::getFolders() as $key => $value)
					<option value="{{ $key }}" <%- documento_folder == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-1 col-xs-2 text-right">
			<div>&nbsp;</div>
			<button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="folder" data-field="documento_folder">
				<i class="fa fa-plus"></i>
			</button>
		</div>
	</div>
    <div class="row">
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label">Consecutivo</label>
			<div class="row">
				@foreach(config('koi.contabilidad.documento.consecutivo') as $key => $value)
					<label class="radio-inline" for="documento_tipo_consecutivo_{{ $key }}">
						<input type="radio" id="documento_tipo_consecutivo_{{ $key }}" name="documento_tipo_consecutivo" value="{{ $key }}" <%- documento_tipo_consecutivo == '{{ $key }}' ? 'checked': ''%>> {{ $value }}
					</label>
				@endforeach
			</div>
		</div>
    </div>
</script>

{{-- Folder --}}
<script type="text/template" id="add-folder-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="folder_codigo" class="control-label">Código</label>
			<input type="text" id="folder_codigo" name="folder_codigo" value="<%- folder_codigo %>" placeholder="Código" class="form-control input-sm input-toupper" maxlength="4" required>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-md-8">
			<label for="folder_nombre" class="control-label">Nombre</label>
			<input type="text" id="folder_nombre" name="folder_nombre" value="<%- folder_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="50" required>
		</div>
    </div>
</script>

{{-- Plan de Cuentas --}}
<script type="text/template" id="add-plancuentas-tpl">
    <div class="row">
		<div class="form-group col-md-3">
			<label for="plancuentas_cuenta" class="control-label">Cuenta</label>
			<div class="row">
				<div class="col-md-9">
					<input type="text" id="plancuentas_cuenta" name="plancuentas_cuenta" value="<%- plancuentas_cuenta %>" placeholder="Cuenta" class="form-control input-sm" maxlength="15" required>
				</div>
				<div class="col-md-3">
					<input type="text" id="plancuentas_nivel" name="plancuentas_nivel" value="<%- plancuentas_nivel %>" class="form-control input-sm" maxlength="1" required readonly>
				</div>
			</div>
		</div>

		<div class="form-group col-md-7">
			<label for="plancuentas_nombre" class="control-label">Nombre</label>
			<input type="text" id="plancuentas_nombre" name="plancuentas_nombre" value="<%- plancuentas_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-6 col-xs-10">
			<label for="plancuentas_centro" class="control-label">Centro de costo</label>
			<select name="plancuentas_centro" id="plancuentas_centro" class="form-control select2-default-clear">
				@foreach( App\Models\Contabilidad\CentroCosto::getCentrosCosto('S') as $key => $value)
					<option value="{{ $key }}" <%- plancuentas_centro == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-1 col-xs-2 text-right">
			<div>&nbsp;</div>
			<button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="centrocosto" data-field="plancuentas_centro">
				<i class="fa fa-plus"></i>
			</button>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-6 col-sm-12 col-xs-12">
			<label class="control-label">Naturaleza</label>
			<div class="row">
				<label class="radio-inline" for="plancuentas_naturaleza_debito">
					<input type="radio" id="plancuentas_naturaleza_debito" name="plancuentas_naturaleza" value="D" <%- plancuentas_naturaleza == 'D' ? 'checked': ''%>> Débito
				</label>

				<label class="radio-inline" for="plancuentas_naturaleza_credito">
					<input type="radio" id="plancuentas_naturaleza_credito" name="plancuentas_naturaleza" value="C" <%- plancuentas_naturaleza == 'C' ? 'checked': ''%>> Crédito
				</label>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="form-group col-md-3 col-sm-12 col-xs-12">
			<label for="plancuentas_tercero">¿Requiere tercero?</label>
			<div class="row">
				<label class="radio-inline" for="plancuentas_tercero_no">
					<input type="radio" id="plancuentas_tercero_no" name="plancuentas_tercero" value="plancuentas_tercero_no" <%- !plancuentas_tercero ? 'checked': ''%>> No
				</label>
				<label class="radio-inline" for="plancuentas_tercero_si">
					<input type="radio" id="plancuentas_tercero_si" name="plancuentas_tercero" value="plancuentas_tercero" <%- plancuentas_tercero ? 'checked': ''%>> Si
				</label>
			</div>
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label">Tipo</label>
			<div class="row">
				@foreach(config('koi.contabilidad.plancuentas.tipo') as $key => $value)
					<label class="radio-inline" for="plancuentas_naturaleza_{{ $key }}">
						<input type="radio" id="plancuentas_naturaleza_{{ $key }}" name="plancuentas_tipo" value="{{ $key }}" <%- plancuentas_tipo == '{{ $key }}' ? 'checked': ''%>> {{ $value }}
					</label>
				@endforeach
			</div>
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-2">
			<label for="plancuentas_tasa" class="control-label">Tasa</label>
			<input type="text" id="plancuentas_tasa" name="plancuentas_tasa" value="<%- plancuentas_tasa ? plancuentas_tasa : '0' %>" placeholder="Tasa" class="form-control input-sm" required>
		</div>
    </div>
</script>

{{-- Centro Costo --}}
<script type="text/template" id="add-centrocosto-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="centrocosto_codigo" class="control-label">Código</label>
			<input type="text" id="centrocosto_codigo" name="centrocosto_codigo" value="<%- centrocosto_codigo %>" placeholder="Código" class="form-control input-sm input-toupper" maxlength="4" required>
		</div>
    	<div class="form-group col-md-3">
			<label for="centrocosto_centro" class="control-label">Centro</label>
			<input type="text" id="centrocosto_centro" name="centrocosto_centro" value="<%- centrocosto_centro %>" placeholder="Centro" class="form-control input-sm input-toupper" maxlength="20" required>
		</div>
		<div class="form-group col-md-7">
			<label for="centrocosto_nombre" class="control-label">Nombre</label>
			<input type="text" id="centrocosto_nombre" name="centrocosto_nombre" value="<%- centrocosto_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
    </div>

	<div class="row">
		<div class="form-group col-md-12">
			<label for="centrocosto_descripcion1" class="control-label">Descripcion 1</label>
			<input type="text" id="centrocosto_descripcion1" name="centrocosto_descripcion1" value="<%- centrocosto_descripcion1 %>" placeholder="Descripcion 1" class="form-control input-sm input-toupper" maxlength="200">
		</div>
    </div>

	<div class="row">
		<div class="form-group col-md-12">
			<label for="centrocosto_descripcion2" class="control-label">Descripcion 2</label>
			<input type="text" id="centrocosto_descripcion2" name="centrocosto_descripcion2" value="<%- centrocosto_descripcion2 %>" placeholder="Descripcion 2" class="form-control input-sm input-toupper" maxlength="200">
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label">Tipo</label>
			<div class="row">
				@foreach(config('koi.contabilidad.centrocosto.tipo') as $key => $value)
					<label class="radio-inline" for="centrocosto_tipo_{{ $key }}">
						<input type="radio" id="centrocosto_tipo_{{ $key }}" name="centrocosto_tipo" value="{{ $key }}" <%- centrocosto_tipo == '{{ $key }}' ? 'checked': '' %> >{{ $value }}
					</label>
				@endforeach
			</div>
		</div>
    </div>

	<div class="row">
		<div class="form-group col-md-2 col-xs-4 col-sm-4">
			<label for="centrocosto_estructura" class="control-label">Titulo</label>
			<select name="centrocosto_estructura" id="centrocosto_estructura" class="form-control" required>
				<option value="N" <%- centrocosto_estructura == 'N' ? 'selected': ''%>>No</option>
				<option value="S" <%- centrocosto_estructura == 'S' ? 'selected': ''%>>Si</option>
			</select>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="centrocosto_activo">
				<input type="checkbox" id="centrocosto_activo" name="centrocosto_activo" value="centrocosto_activo" <%- parseInt(centrocosto_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

{{--Template Inventarios--}}
<script type="text/template" id="add-categoria-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="categoria_nombre" class="control-label">Nombre</label>
			<input type="text" id="categoria_nombre" name="categoria_nombre" value="<%- categoria_nombre %>" placeholder="Categoria" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="categoria_activo">
				<input type="checkbox" id="categoria_activo" name="categoria_activo" value="categoria_activo" <%- categoria_activo ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
<script type="text/template" id="add-marca-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="marca_nombre" class="control-label">Nombre</label>
			<input type="text" id="marca_nombre" name="marca_nombre" value="<%- marca_nombre %>" placeholder="Marca" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="marca_activo">
				<input type="checkbox" id="marca_activo" name="marca_activo" value="marca_activo" <%- marca_activo ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>


<script type="text/template" id="add-modelo-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="modelo_nombre" class="control-label">Nombre</label>
			<input type="text" id="modelo_nombre" name="modelo_nombre" value="<%- modelo_nombre %>" placeholder="Modelo" class="form-control input-sm input-toupper" maxlength="100" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="modelo_activo">
				<input type="checkbox" id="modelo_activo" name="modelo_activo" value="modelo_activo" <%- modelo_activo ? 'checked': ''%>> Activo
			</label>
		</div>
	</div>
</script>
<script type="text/template" id="add-linea-tpl">
    <div class="row">
		<div class="form-group col-md-7">
			<label for="linea_nombre" class="control-label">Nombre</label>
			<input type="text" id="linea_nombre" name="linea_nombre" value="<%- linea_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="50" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-2">
			<br><label class="checkbox-inline" for="linea_activo">
				<input type="checkbox" id="linea_activo" name="linea_activo" value="linea_activo" <%- parseInt(linea_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-md-3">
			<label for="linea_margen_nivel1" class="control-label">Margen Nivel 1</label>
			<input type="number" id="linea_margen_nivel1" name="linea_margen_nivel1" value="<%- linea_margen_nivel1 %>" placeholder="Margen" class="form-control input-sm " maxlength="50" required>
		</div>
		<div class="form-group col-md-3">
			<label for="linea_margen_nivel2" class="control-label">Margen Nivel 2</label>
			<input type="number" id="linea_margen_nivel2" name="linea_margen_nivel2" value="<%- linea_margen_nivel2 %>" placeholder="Margen" class="form-control input-sm " maxlength="50" required>
		</div>
		<div class="form-group col-md-3">
			<label for="linea_margen_nivel3" class="control-label">Margen Nivel 3</label>
			<input type="number" id="linea_margen_nivel3" name="linea_margen_nivel3" value="<%- linea_margen_nivel3 %>" placeholder="Margen" class="form-control input-sm " maxlength="50" required>
		</div>
    </div>
</script>

<script type="text/template" id="add-unidad-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="unidadmedida_sigla " class="control-label">Sigla</label>
			<input type="text" id="unidadmedida_sigla" name="unidadmedida_sigla" value="<%- unidadmedida_sigla %>" placeholder="Sigla" class="form-control input-sm input-toupper" maxlength="15" required>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-md-6">
		<label for="unidadmedida_nombre" class="control-label">Nombre</label>
			<input type="text" id="unidadmedida_nombre" name="unidadmedida_nombre" value="<%- unidadmedida_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<br>
		<div class="form-group col-md-1">
			<label class="checkbox-inline" for="unidad_medida_activo">
				<input type="checkbox" id="unidad_medida_activo" name="unidad_medida_activo" value="unidad_medida_activo" <%- parseInt(unidad_medida_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

