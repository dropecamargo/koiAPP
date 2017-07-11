{{-- Administrativo --}}
<script type="text/template" id="add-tercero-tpl">
	<form method="POST" accept-charset="UTF-8" id="form-tercero" data-toggle="validator">
		<div class="row">
			<div class="form-group col-md-3">
				<label for="tercero_nit" class="control-label">Documento</label>
				<div class="row">
					<div class="col-md-9">
						<input id="tercero_nit" value="<%- tercero_nit %>" placeholder="Nit" class="form-control input-sm change-nit-koi-component" name="tercero_nit" type="text" required data-field="tercero_digito">
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
				<label for="tercero_direccion" class="control-label">Dirección</label> <small id="tercero_nomenclatura"><%- tercero_dir_nomenclatura %></small>
	      		<div class="input-group input-group-sm">
      		 		<input type="hidden" id="tercero_dir_nomenclatura" name="tercero_dir_nomenclatura" value="<%- tercero_dir_nomenclatura %>">
					<input id="tercero_direccion" value="<%- tercero_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="tercero_direccion" type="text" data-nm-name="tercero_nomenclatura" data-nm-value="tercero_dir_nomenclatura" required>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tercero_direccion">
							<i class="fa fa-map-signs"></i>
						</button>
					</span>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_municipio" class="control-label">Municipio</label>
				<select name="tercero_municipio" id="tercero_municipio" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('municipios.index'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tercero_municipio %>">
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="tercero_pais" class="control-label">Pais</label>
				<select name="tercero_pais" id="tercero_pais" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('paises.index'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tercero_pais %>">
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
					<input id="tercero_telefono1" value="<%- tercero_telefono1 %>" class="form-control input-sm" name="tercero_telefono1" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_telefono2" class="control-label">2do. Teléfono</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-phone"></i>
					</div>
					<input id="tercero_telefono2" value="<%- tercero_telefono2 %>" class="form-control input-sm" name="tercero_telefono2" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
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
	    		<input id="tercero_cc_representante" value="<%- tercero_cc_representante %>" placeholder="Cédula" class="form-control input-sm" name="tercero_cc_representante" type="text" maxlength="15">
	    	</div>
			<div class="form-group col-md-3">
	    		<label for="tercero_familia" class="control-label">Familia</label>
	    		<input id="tercero_familia" value="<%- tercero_familia %>" placeholder="Familia" class="form-control input-sm input-toupper" name="tercero_familia" type="text" maxlength="10">
	    	</div>
		</div>

	    <div class="row">
            <div class="col-md-offset-4 col-md-2 col-sm-6 col-xs-6">
                <a href="<%- window.Misc.urlFull( (typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') ? Route.route('terceros.show', { terceros: id}) : Route.route('terceros.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6">
                <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
            </div>
        </div>
	</form>

	<br/>
	<div class="row">
    	<div class="form-group col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
						<li><a id="wrapper-empleados" href="#tab_empleados" data-toggle="tab" class="<%- parseInt(tercero_empleado) || parseInt(tercero_interno) ? '' : 'hide' %>">Empleado</a></li>
						<li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
					<% } %>
				</ul>

				<div class="tab-content">
					{{-- Tab contabilidad --}}
					<div class="tab-pane active" id="tab_contabilidad">
						<form method="POST" accept-charset="UTF-8" id="form-accounting" data-toggle="validator">
				    	    <div class="row">
						    	<div class="form-group col-md-10">
									<label for="tercero_actividad" class="control-label">Actividad Económica</label>
									<select name="tercero_actividad" id="tercero_actividad" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('actividades.index'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tercero_actividad %>">
									</select>
						    	</div>
						    	<div class="form-group col-md-2">
						    		<label for="tercero_retecree" class="control-label">% Cree</label>
						    		<div id="tercero_retecree"><%- actividad_tarifa %></div>
						    	</div>
						    </div>

						    <div class="row">
						    	<div class="form-group col-md-2">
									<label class="checkbox-inline" for="tercero_cliente">
										<input type="checkbox" id="tercero_cliente" name="tercero_cliente" value="tercero_cliente" <%- parseInt(tercero_cliente) ? 'checked': ''%>> Cliente
									</label>
								</div>
								<div class="form-group col-md-2">
									<label class="checkbox-inline" for="tercero_acreedor">
										<input type="checkbox" id="tercero_acreedor" name="tercero_acreedor" value="tercero_acreedor" <%- parseInt(tercero_acreedor) ? 'checked': ''%>> Acreedor
									</label>
								</div>
								<div class="form-group col-md-2">
									<label class="checkbox-inline" for="tercero_proveedor">
										<input type="checkbox" id="tercero_proveedor" name="tercero_proveedor" value="tercero_proveedor" <%- parseInt(tercero_proveedor) ? 'checked': ''%>> Proveedor
									</label>
								</div>
								<div class="form-group col-md-2">
									<label class="checkbox-inline" for="tercero_autoretenedor_ica">
										<input type="checkbox" id="tercero_autoretenedor_ica" name="tercero_autoretenedor_ica" value="tercero_autoretenedor_ica" <%- parseInt(tercero_autoretenedor_ica) ? 'checked': ''%>> Autorretenedor ICA
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
										<input type="checkbox" id="tercero_empleado" name="tercero_empleado" value="tercero_empleado" <%- parseInt(tercero_empleado) ? 'checked': ''%> class="change_employee"> Empleado
									</label>
								</div>
								<div class="form-group col-md-2">
									<label class="checkbox-inline" for="tercero_interno">
										<input type="checkbox" id="tercero_interno" name="tercero_interno" value="tercero_interno" <%- parseInt(tercero_interno) ? 'checked': ''%> class="change_employee"> Interno
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
									<label class="checkbox-inline" for="tercero_otro">
										<input type="checkbox" id="tercero_otro" name="tercero_otro" value="tercero_otro" <%- parseInt(tercero_otro) ? 'checked': ''%>> Otro
									</label>
								</div>

								<div class="form-group col-md-2">
									<input id="tercero_cual" value="<%- tercero_cual %>" placeholder="¿Cual?" class="form-control input-sm" name="tercero_cual" type="text" maxlength="15">
								</div>
						    </div>
						</form>
					</div>

					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
						{{-- Tab empleados --}}
						<div class="tab-pane" id="tab_empleados">
							<form method="POST" accept-charset="UTF-8" id="form-employee" data-toggle="validator">
								<div class="row">
							    	<div class="form-group col-md-6">
										<div class="row">
									    	<div class="form-group col-md-4">
										    	<label class="checkbox-inline" for="tercero_activo">
													<input type="checkbox" id="tercero_activo" name="tercero_activo" value="tercero_activo" <%- parseInt(tercero_activo) ? 'checked': ''%>> Activo
												</label>
											</div>
									    	<div class="form-group col-md-4">
										    	<label class="checkbox-inline" for="tercero_tecnico">
													<input type="checkbox" id="tercero_tecnico" name="tercero_tecnico" value="tercero_tecnico" <%- parseInt(tercero_tecnico) ? 'checked': ''%>> Técnico
												</label>
											</div>
										</div>

										<div class="row">
											<div class="form-group col-md-4">
										    	<label class="checkbox-inline" for="tercero_coordinador">
													<input type="checkbox" id="tercero_coordinador" name="tercero_coordinador" value="tercero_coordinador" <%- parseInt(tercero_coordinador) ? 'checked': ''%>> Coordinador
												</label>
											</div>

											<div class="form-group col-md-4">
										    	<label class="checkbox-inline" for="tercero_vendedor">
													<input type="checkbox" id="tercero_vendedor" name="tercero_vendedor" value="tercero_vendedor" <%- parseInt(tercero_vendedor) ? 'checked': ''%>> Vendedor
												</label>
											</div>
										</div>	

										<div class="row">
										   	<div id="wrapper-coordinador" class="form-group col-md-10 col-md-offset-1 <%- parseInt(tercero_tecnico) || parseInt(tercero_vendedor) ? '' : 'hide' %>">
												<label for="tercero_coordinador_por" class="control-label">Coordinado por</label>
												<select name="tercero_coordinador_por" id="tercero_coordinador_por" class="form-control select2-default" data-tecnico required>
										            @foreach( App\Models\Base\Tercero::getTechnicalAdministrators() as $key => $value)
										                <option value="{{ $key }}" <%- tercero_coordinador_por == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
										            @endforeach
										        </select>
										    </div>
										</div>
									</div>
									
							    	<div class="form-group col-md-6">
										<div class="row">
										    <div class="form-group col-md-10">
												<label for="tercero_sucursal" class="control-label">Sucursal</label>
										        <select name="tercero_sucursal" id="tercero_sucursal" class="form-control select2-default" required>
											        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
											        	<option  value="{{ $key }}" <%- tercero_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
											        @endforeach
										        </select>
										    </div>
										</div>
									</div>
								</div>
							</form>

							<br />
							<div class="row">
								<div class="form-group col-md-6">
					            	<div class="box box-success" id="wrapper-password">
										<div class="box-header with-border">
											<h3 class="box-title">Datos de acceso</h3>
										</div>
										<div class="box-body">
											<form method="POST" accept-charset="UTF-8" id="form-changed-password" data-toggle="validator">
												<div class="row">
													<div class="form-group col-md-12">
														<label for="username" class="control-label">Cuenta de usuario</label>
														<input type="text" name="username" id="username" class="form-control input-lower" value="<%- username %>" minlength="4" maxlength="20" required>
													</div>
												</div>

												<div class="row">
													<div class="form-group col-md-6">
													<label for="password" class="control-label">Contraseña</label>
														<input type="password" name="password" id="password" class="form-control" minlength="6" maxlength="15">
														<div class="help-block">Minimo de 6 caracteres</div>
													</div>

													<div class="form-group col-md-6">
													<label for="password_confirmation" class="control-label">Verificar contraseña</label>
														<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" data-match="#password" data-match-error="Oops, no coinciden la contraseña" minlength="6" maxlength="15">
														<div class="help-block with-errors"></div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12 text-center">
														<button type="submit" class="btn btn-success change-pass">Cambiar</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
						    	<div class="form-group col-md-6">
									<div class="box box-success" id="wrapper-roles">
										<div class="box-header with-border">
											<h3 class="box-title">Roles de usuario</h3>
										</div>
							            <div class="box-body">
						                    <form method="POST" accept-charset="UTF-8" id="form-item-roles" data-toggle="validator">
						                        <div class="row">
						                        	<label for="role_id" class="control-label col-sm-1 col-md-offset-1 hidden-xs">Rol</label>
						                            <div class="form-group col-md-7 col-xs-9">
						                                <select name="role_id" id="role_id" class="form-control select2-default" required>
						                                    @foreach( App\Models\Base\Rol::getRoles() as $key => $value)
						                                        <option value="{{ $key }}">{{ $value }}</option>
						                                    @endforeach
						                                </select>
						                            </div>
						                            <div class="form-group col-md-2 col-xs-3">
						                                <button type="submit" class="btn btn-success btn-sm btn-block">
						                                    <i class="fa fa-plus"></i>
						                                </button>
						                            </div>
						                        </div>
						                    </form>
						                    <!-- table table-bordered table-striped -->
						                    <div class="table-responsive no-padding">
						                        <table id="browse-roles-list" class="table table-hover table-bordered" cellspacing="0">
						                            <thead>
						                                <tr>
						                                    <th width="5%"></th>
						                                    <th width="95%">Nombre</th>
						                                </tr>
						                            </thead>
						                            <tbody>
						                                {{-- Render content roles --}}
						                            </tbody>
						                        </table>
						                    </div>
						                </div>
						            </div>
					            </div>
							</div>
						</div>

						{{-- Tab contactos --}}
						<div class="tab-pane" id="tab_contactos">
						    <div class="row">
								<div class="col-md-offset-4 col-md-4 col-sm-offset-2 col-sm-8 col-xs-12">
									<button type="button" class="btn btn-primary btn-block btn-sm btn-add-tcontacto" data-resource="contacto" data-tercero="<%- id %>">
										<i class="fa fa-user-plus"></i>  Nuevo contacto
									</button>
								</div>
							</div>
							<br />

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
					<% } %>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="add-contacto-tpl">
    <div class="row">
		<div class="form-group col-md-4">
			<label for="tcontacto_nombres" class="control-label">Nombres</label>
			<input type="text" id="tcontacto_nombres" name="tcontacto_nombres" value="<%- tcontacto_nombres %>" placeholder="Nombres" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>

		<div class="form-group col-md-4">
			<label for="tcontacto_apellidos" class="control-label">Apellidos</label>
			<input type="text" id="tcontacto_apellidos" name="tcontacto_apellidos" value="<%- tcontacto_apellidos %>" placeholder="Apellidos" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
    </div>

    <div class="row">
    	<div class="form-group col-md-4">
			<label for="tcontacto_direccion" class="control-label">Dirección</label> <small id="tcontacto_dir_nomenclatura"><%- tcontacto_direccion_nomenclatura %></small>
      		<div class="input-group input-group-sm">
  		 		<input type="hidden" id="tcontacto_direccion_nomenclatura" name="tcontacto_direccion_nomenclatura" value="<%- tcontacto_direccion_nomenclatura %>">
				<input id="tcontacto_direccion" value="<%- tcontacto_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="tcontacto_direccion" type="text" maxlength="200" required data-nm-name="tcontacto_dir_nomenclatura" data-nm-value="tcontacto_direccion_nomenclatura">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tcontacto_direccion">
						<i class="fa fa-map-signs"></i>
					</button>
				</span>
			</div>
		</div>

    	<div class="form-group col-md-4">
			<label for="tcontacto_municipio" class="control-label">Municipio</label>
			<select name="tcontacto_municipio" id="tcontacto_municipio" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('municipios.index'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tcontacto_municipio %>">
			</select>
		</div>

		<div class="form-group col-md-4">
			<label for="tcontacto_nombres" class="control-label">Email</label>
			<input id="tcontacto_email" value="<%- tcontacto_email %>" placeholder="Email" class="form-control input-sm" name="tcontacto_email" type="email" maxlength="200">
		    <div class="help-block with-errors"></div>
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-4">
			<label for="tcontacto_cargo" class="control-label">Cargo</label>
			<input type="text" id="tcontacto_cargo" name="tcontacto_cargo" value="<%- tcontacto_cargo %>" placeholder="Cargos" class="form-control input-sm input-toupper" maxlength="200">
		</div>

		<div class="form-group col-md-4">
			<label for="tcontacto_telefono" class="control-label">Teléfono</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-phone"></i>
				</div>
				<input id="tcontacto_telefono" value="<%- tcontacto_telefono %>" class="form-control input-sm" name="tcontacto_telefono" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask required>
			</div>
		</div>

		<div class="form-group col-md-4">
			<label for="tcontacto_celular" class="control-label">Celular</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-mobile"></i>
				</div>
				<input id="tcontacto_celular" value="<%- tcontacto_celular %>" class="form-control input-sm" name="tcontacto_celular" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
			</div>
		</div>
	</div>
</script>

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
			<label for="actividad_categoria" class="control-label">Categoria</label>
			<input type="text" id="actividad_categoria" name="actividad_categoria" value="<%- actividad_categoria %>" placeholder="Categoria" class="form-control input-sm input-toupper" maxlength="3">
		</div>
		<div class="form-group col-md-2">
			<label for="actividad_tarifa" class="control-label">% Cree</label><br>
			<input type="text" id="actividad_tarifa" name="actividad_tarifa" value="<%- actividad_tarifa %>" placeholder="% Cree" class="form-control input-sm spinner-percentage" maxlength="4" required>
		</div>
	</div>
</script>

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
<script type="text/template" id="add-tipoajuste-tpl">
    <div class="row">
		<div class="col-md-2">
			<label for="tipoajuste_sigla" class="control-label">Sigla</label>
			<input type="text" id="tipoajuste_sigla" name="tipoajuste_sigla" value="<%- tipoajuste_sigla %>" placeholder="Sigla" class="form-control input-sm input-toupper" maxlength="3" required>
		</div>
		<div class="col-md-6">
			<label for="tipoajuste_nombre" class="control-label">Nombre</label>
			<input type="text" id="tipoajuste_nombre" name="tipoajuste_nombre" value="<%- tipoajuste_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-2">
			<label for="tipoajuste_tipo" class="control-label">Tipo</label>
		 	<select name="tipoajuste_tipo" id="tipoajuste_tipo" class="form-control select2-default" required>
                    @foreach(config('koi.tipoInventario') as $key => $value)
                        <option value="{{ $key }}" <%- tipoajuste_tipo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
            </select>
		</div><br>
    	<div class="col-md-3">
	    	<label class="checkbox-inline" for="tipoajuste_activo">
				<input type="checkbox" id="tipoajuste_activo" name="tipoajuste_activo" value="tipoajuste_activo" <%- parseInt(tipoajuste_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
	</div>
</script>
<script type="text/template" id="add-tipotraslado-tpl">
    <div class="row">
		<div class="col-md-2">
			<label for="tipotraslado_sigla" class="control-label">Sigla</label>
			<input type="text" id="tipotraslado_sigla" name="tipotraslado_sigla" value="<%- tipotraslado_sigla %>" placeholder="Sigla" class="form-control input-sm input-toupper" maxlength="3" required>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="tipotraslado_nombre" class="control-label">Nombre</label>
			<input type="text" id="tipotraslado_nombre" name="tipotraslado_nombre" value="<%- tipotraslado_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div><br>
    	<div class="col-md-3">
	    	<label class="checkbox-inline" for="tipotraslado_activo">
				<input type="checkbox" id="tipotraslado_activo" name="tipotraslado_activo" value="tipotraslado_activo" <%- parseInt(tipotraslado_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
	</div>
</script>

<script type="text/template" id="add-puntoventa-tpl">
    <div class="row">
		<div class="form-group col-md-6">
			<label for="puntoventa_nombre" class="control-label">Nombre</label>
			<input type="text" id="puntoventa_nombre" name="puntoventa_nombre" value="<%- puntoventa_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
		<div class="form-group col-md-2">
			<label for="puntoventa_numero" class="control-label">Consecutivo</label>
			<input type="number" id="puntoventa_numero" name="puntoventa_numero" value="<%- puntoventa_numero %>" class="form-control input-sm" min="0">
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
		<div class="col-md-3"><br>
	    	<label class="checkbox-inline" for="puntoventa_activo">
				<input type="checkbox" id="puntoventa_activo" name="puntoventa_activo" value="puntoventa_activo" <%- parseInt(puntoventa_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="contact-item-list-tpl">
	<td><%- tcontacto_nombres %> <%- tcontacto_apellidos %></td>
	<td><%- tcontacto_direccion %></td>
	<td><%- tcontacto_telefono %></td>
	<td><%- tcontacto_celular %></td>
	<td class="text-center">
		<a class="btn btn-default btn-xs btn-edit-tcontacto" data-resource="<%- id %>">
			<span><i class="fa fa-pencil-square-o"></i></span>
		</a>
	</td>
</script>

<script type="text/template" id="roles-item-list-tpl">
	<% if(edit) { %>
        <td class="text-center">
            <a class="btn btn-default btn-xs item-roles-remove" data-resource="<%- id %>">
                <span><i class="fa fa-times"></i></span>
            </a>
    	</td>
    <% } %>
	<td><%- display_name %></td>
</script>

{{-- Contabilidad --}}
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

{{-- Inventarios--}}
<script type="text/template" id="add-categoria-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="categoria_nombre" class="control-label">Nombre</label>
			<input type="text" id="categoria_nombre" name="categoria_nombre" value="<%- categoria_nombre %>" placeholder="Categoria" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="categoria_activo">
				<input type="checkbox" id="categoria_activo" name="categoria_activo" value="categoria_activo" <%- parseInt(categoria_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
<script type="text/template" id="add-subcategoria-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="subcategoria_nombre" class="control-label">Nombre</label>
			<input type="text" id="subcategoria_nombre" name="subcategoria_nombre" value="<%- subcategoria_nombre %>" placeholder="SubCategoria" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-md-2">
			<label for="subcategoria_margen_nivel1" class="control-label">Margen Nivel 1</label>
			<input type="text" id="subcategoria_margen_nivel1" name="subcategoria_margen_nivel1" value="<%- subcategoria_margen_nivel1 %>" placeholder="Margen" class="form-control input-sm spinner-percentage" maxlength="4" required>
		</div>

		<div class="form-group col-md-2">
			<label for="subcategoria_margen_nivel2" class="control-label">Margen Nivel 2</label>
			<input type="text" id="subcategoria_margen_nivel2" name="subcategoria_margen_nivel2" value="<%- subcategoria_margen_nivel2 %>" placeholder="Margen" class="form-control input-sm spinner-percentage" maxlength="4" required>
		</div>

		<div class="form-group col-md-2">
			<label for="subcategoria_margen_nivel3" class="control-label">Margen Nivel 3</label>
			<input type="text" id="subcategoria_margen_nivel3" name="subcategoria_margen_nivel3" value="<%- subcategoria_margen_nivel3 %>" placeholder="Margen" class="form-control input-sm spinner-percentage" maxlength="4" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="subcategoria_activo">
				<input type="checkbox" id="subcategoria_activo" name="subcategoria_activo" value="subcategoria_activo" <%- parseInt(subcategoria_activo) ? 'checked': ''%>> Activo
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
				<input type="checkbox" id="marca_activo" name="marca_activo" value="marca_activo" <%- parseInt(marca_activo) ? 'checked': ''%>> Activo
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
				<input type="checkbox" id="modelo_activo" name="modelo_activo" value="modelo_activo" <%- parseInt(modelo_activo) ? 'checked': ''%>> Activo
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
<script type="text/template" id="add-unidadnegocio-tpl">
    <div class="row">
		<div class="form-group col-md-6">
		<label for="unidadnegocio_nombre" class="control-label">Nombre</label>
			<input type="text" id="unidadnegocio_nombre" name="unidadnegocio_nombre" value="<%- unidadnegocio_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<br>
		<div class="form-group col-md-1">
			<label class="checkbox-inline" for="unidadnegocio_activo">
				<input type="checkbox" id="unidadnegocio_activo" name="unidadnegocio_activo" value="unidadnegocio_activo" <%- parseInt(unidadnegocio_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="add-bitacora-item-tpl"> 
    <td><%- tercero_nombre %></td>
    <td><%- bitacora_campo %></td>
    <td> <%- bitacora_anterior %></td>
    <td> <%- bitacora_nuevo %></td>
    <td><%- bitacora_fh_elaboro %></td>
</script>

<script type="text/template" id="add-serie-tpl">
    <td class="text-center"><%- id %></td>
    <td>
    	<input type="text" id="producto_serie_<%- id %>" name="producto_serie_<%- id %>" class="form-control input-sm input-toupper" maxlength="15" required>
    </td>
</script>

<script type="text/template" id="exit-lotes-tpl">
    <td class="text-left"><%- lote_numero %></td>
    <td class="text-left"><%- lote_fecha %></td>
    <% if(lote_vencimiento != null) { %>
    	<td class="text-left"><%- lote_vencimiento %></td>
    <% } %> 
    <td class="text-left"><%- lote_cantidad %></td>
    <td class="text-left"><%- lote_saldo %></td>
    <td>
    	<div class="form-group">
    		<input type="number" id="item_<%- id %>" name="item_<%- id %>" class="form-control input-sm input-toupper cantidad-salidau-koi-inventario" value="0" min="0" max="<%- lote_saldo %>">
    	</div>
    </td>
</script>

<script type="text/template" id="add-itemsrollos-tpl">
	<td>
		<input type="text" id="rollos_lote_<%- id %>" name="rollos_lote_<%- id %>" class="form-control input-sm" min="1" value="<%- rollo_lote %>">
	</td>
	<td>
		<input type="number" id="rollos_<%- id %>" name="rollos_<%- id %>" class="form-control input-sm" min="1" value="<%- rollo_cantidad %>">
	</td>
    <td>
		<input id="itemrollo_metros_<%- id %>" name="itemrollo_metros_<%- id %>" class="form-control input-sm" type="number" value="<%- rollo_metros %>" min="0" step="0.01" required>
    </td>
    <td class="text-center">
		<button type="button" class="btn btn-default btn-xs btn-remove-itemrollo-koi-inventario" data-resource="<%- id %>">
			<i class="fa fa-close"></i>
		</button>
    </td>
</script>

<script type="text/template" id="add-itemsvencimiento-tpl">
	<td>
		<input type="text" id="prodbodevence_lote_<%- id %>" name="prodbodevence_lote_<%- id %>" class="form-control input-sm input-toupper" value="<%- lote_numero %>">
	</td>
    <td>
		<input id="prodbodevence_unidades_<%- id %>" name="prodbodevence_unidades_<%- id %>" class="form-control input-sm unidades-vence-koi-inventario" type="number" value="<%- lote_cantidad %>" min="0" required>
    </td>
    <td>
    	<input type="text" id="prodbodevence_fecha_<%- id %>" name="prodbodevence_fecha_<%- id %>" class="form-control datepicker input-sm" value="<%- lote_fecha %>">
    </td>
    <td class="text-center">
		<button type="button" class="btn btn-default btn-xs btn-remove-itemvencimiento-koi-inventario" data-resource="<%- id %>">
			<i class="fa fa-close"></i>
		</button>
    </td>
</script>

<script type="text/template" id="chooses-itemsrollos-tpl">
    <td class="text-left"><%- id %></td>
    <td class="text-left"><%- rollo_lote %></td>
    <td class="text-left"><%- rollo_fecha %></td>
    <td class="text-left"><%- rollo_metros %></td>
    <td class="text-left"><%- rollo_saldo %></td>
    <td>
    	<div class="form-group">
			<input id="item_<%- id %>" name="item_<%- id %>" class="form-control input-sm cantidad-salidau-koi-inventario" type="number" value="0" min="0" max="<%- rollo_saldo %>" step="0.1">
    	</div>
    </td>
</script>
{{-- Comercial --}}
<script type="text/template" id="add-conceptocom-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="conceptocom_nombre" class="control-label">Nombre</label>
			<input type="text" id="conceptocom_nombre" name="conceptocom_nombre" value="<%- conceptocom_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptocom_activo">
				<input type="checkbox" id="conceptocom_activo" name="conceptocom_activo" value="conceptocom_activo" <%- parseInt(conceptocom_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
{{-- Cartera --}}
<script type="text/template" id="add-banco-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="banco_nombre" class="control-label">Nombre</label>
			<input type="text" id="banco_nombre" name="banco_nombre" value="<%- banco_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="banco_activo">
				<input type="checkbox" id="banco_activo" name="banco_activo" value="banco_activo" <%- parseInt(banco_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
<script type="text/template" id="add-causa-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="causal_nombre" class="control-label">Nombre</label>
			<input type="text" id="causal_nombre" name="causal_nombre" value="<%- causal_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="causal_activo">
				<input type="checkbox" id="causal_activo" name="causal_activo" value="causal_activo" <%- parseInt(causal_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
<script type="text/template" id="add-conceptocob-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="conceptocob_nombre" class="control-label">Nombre</label>
			<input type="text" id="conceptocob_nombre" name="conceptocob_nombre" value="<%- conceptocob_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptocob_activo">
				<input type="checkbox" id="conceptocob_activo" name="conceptocob_activo" value="conceptocob_activo" <%- parseInt(conceptocob_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="add-mediopago-tpl">
	<div class="row">
		<div class="form-group col-md-4">
			<label for="mediopago_nombre" class="control-label">Nombre</label>
			<input type="text" id="mediopago_nombre" name="mediopago_nombre" value="<%- mediopago_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-1 col-xs-8 col-sm-2">
			<br><label class="checkbox-inline" for="mediopago_activo">
				<input type="checkbox" id="mediopago_activo" name="mediopago_activo" value="mediopago_activo" <%- parseInt(mediopago_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
		<div class="form-group col-md-1 col-xs-8 col-sm-2">
			<br><label class="checkbox-inline" for="mediopago_ef">
				<input type="checkbox" id="mediopago_ef" name="mediopago_ef" value="mediopago_ef" <%- parseInt(mediopago_ef) ? 'checked': ''%>> Efectivo
			</label>
		</div>
		<div class="form-group col-md-1 col-xs-8 col-sm-2">
			<br><label class="checkbox-inline" for="mediopago_ch">
				<input type="checkbox" id="mediopago_ch" name="mediopago_ch" value="mediopago_ch" <%- parseInt(mediopago_ch) ? 'checked': ''%>> Cheque
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="add-cuentabanco-tpl">
	<div class="row">
		<div class="form-group col-md-5">
			<label for="cuentabanco_nombre" class="control-label">Nombre</label>
			<input type="text" id="cuentabanco_nombre" name="cuentabanco_nombre" value="<%- cuentabanco_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="50" required>
		</div>
		<div class="form-group col-md-3">
			<label for="cuentabanco_numero" class="control-label">Numero</label>
			<input type="text" id="cuentabanco_numero" name="cuentabanco_numero" value="<%- cuentabanco_numero %>" placeholder="Numero" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-sm-6 col-md-2">
			<label for="cuentabanco_plancuentas" class="control-label text-right">Cuenta</label>
      		<div class="input-group input-group-sm">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="cuentabanco_plancuentas">
						<i class="fa fa-tasks"></i>
					</button>
				</span>
				<input id="cuentabanco_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="cuentabanco_plancuentas" type="text" maxlength="15" data-wrapper="asientos-create" data-name="cuenta_nombre" value="<%- plancuentas_cuenta %>">
			</div>
		</div>
		<div class="col-sm-6 col-md-4"><br>
			<input id="cuenta_nombre" name="cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" disabled>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-3">
			<label for="cuentabanco_banco" class="control-label">Banco</label>
			<select name="cuentabanco_banco" id="cuentabanco_banco" class="form-control select2-default" required>
				<option value="" selected>Seleccione</option>
				@foreach( App\Models\Cartera\Banco::getBancos() as $key => $value)
					<option value="{{ $key }}" <%- cuentabanco_banco == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
 
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="cuentabanco_activa">
				<input type="checkbox" id="cuentabanco_activa" name="cuentabanco_activa" value="cuentabanco_activa" <%- parseInt(cuentabanco_activa) ? 'checked': ''%>> Activo
			</label>
		</div>
	</div>
</script>

<script type="text/template" id="add-conceptosrc-tpl">
	<div class="row">
		<div class="form-group col-md-3">
			<label for="conceptosrc_nombre" class="control-label">Nombre</label>
			<input type="text" id="conceptosrc_nombre" name="conceptosrc_nombre" value="<%- conceptosrc_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<div class="form-group col-md-3">
			<label for="conceptosrc_documentos" class="control-label">Documento</label>
			<select name="conceptosrc_documentos" id="conceptosrc_documentos" class="form-control select2-default">
				<option value="" selected>Seleccione</option>
				@foreach( App\Models\Base\Documentos::getDocumentos() as $key => $value)
					<option value="{{ $key }}" <%- conceptosrc_documentos == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-sm-6 col-md-2">
			<label for="conceptosrc_plancuentas" class="control-label text-right">Cuenta</label>
      		<div class="input-group input-group-sm">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="conceptosrc_plancuentas">
						<i class="fa fa-tasks"></i>
					</button>
				</span>
				<input id="conceptosrc_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="conceptosrc_plancuentas" type="text" maxlength="15" data-wrapper="asientos-create" data-name="cuenta_nombre" value="<%- plancuentas_cuenta %>">
			</div>
		</div>
		<div class="col-sm-6 col-md-4"><br>
			<input id="cuenta_nombre" name="cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" disabled>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptosrc_activo">
				<input type="checkbox" id="conceptosrc_activo" name="conceptosrc_activo" value="conceptosrc_activo" <%- parseInt(conceptosrc_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
	</div>
</script>

<script type="text/template" id="add-concepto-item-tpl"> 
    <% if( factura3_factura1 == '' ) { %>
        <th colspan="7" class="text-center">NO EXISTEN FACTURAS DE ESTE CLIENTE</th>
	<% }else{ %>
	    <td><input type="checkbox" id="check_<%- id %>" name="check_<%- id %>" class="change-check"></td>
	    <td><%- moment(factura1_fh_elaboro).format('YYYY-MM-DD') %></td>
	    <td><%- factura3_vencimiento %></td>
	    <td><%- factura1_numero %></td>
	    <td><%- factura3_cuota %></td>
	    <td><%- window.Misc.currency(factura3_saldo) %></td>
	    <td><input type="text" id="pagar_<%- id %>" name="pagar_<%- id %>" class="form-control input-sm change-pagar" data-currency-negative></td>
	<% } %>
</script>

<script type="text/template" id="add-cheque-item-tpl">
    <%if(edit){ %>
        <td class="text-center">
            <a class="btn btn-default btn-xs item-cheque-remove" data-resource="<%- id %>">
                <span><i class="fa fa-times"></i></span>
            </a>
        </td>
    <% } %>
        	
    <td><%- conceptosrc_nombre %></td>
    <td><%- documentos_nombre %></td>
    <td><%- !_.isUndefined(factura1_numero) && !_.isNull(factura1_numero) && factura1_numero != '' ? factura1_numero : '' %></td>
    <td><%- !_.isUndefined(factura3_cuota) && !_.isNull(factura3_cuota) && factura3_cuota != '' ? factura3_cuota : '' %></td>
    <td class="text-right"><%- !_.isUndefined(factura3_valor) && !_.isNull(factura3_valor) && factura3_valor != '' ? window.Misc.currency( factura3_valor ) : '' %></td>
</script>

<script type="text/template" id="choose-cheque-item-tpl">
    <td class="text-center">
    	<input type="checkbox" name="check_<%- id_cheque %>" id="check_<%- id_cheque %>" class="change-check-medio">
    </td>
        	
    <td><%- banco_nombre %></td>
    <td><%- chposfechado1_ch_numero %></td>
    <td><%- window.Misc.currency( chposfechado1_valor ) %></td>
    <td><%- chposfechado1_ch_fecha %></td>
</script>

<script type="text/template" id="choose-chd-item-tpl">
    <td class="text-center">
    	<input type="checkbox" name="check_<%- id %>" id="check_<%- id %>" class="click-concepto-chd">
    </td>
    <td><%- banco_nombre %></td>
    <td><%- chposfechado1_ch_numero %></td>
    <td><%- chdevuelto_fecha %></td>
    <% if( call == 'ajustesc' ) { %> 
    	<td><input type="checkbox" id="debito_<%- id %>" name="debito_<%- id %>" class="change-naturalezachd"></td>
    	<td><input type="checkbox" id="credito_<%- id %>" name="credito_<%- id %>" class="change-naturalezachd"></td>
    <% } %>
    <td><%- window.Misc.currency( chdevuelto_saldo ) %></td>
    <td><input type="text" id="pagar_<%- id %>" name="pagar_<%- id %>" class="form-control input-sm change-pagar-chd" data-currency-negative></td>
</script>

<script type="text/template" id="choose-anticipo-item-tpl">
    <td class="text-center">
    	<input type="checkbox" name="check_<%- id %>" id="check_<%- id %>" class="click-check-anti-koi">
    </td>
    <td><%- cuentabanco_nombre %></td>
    <td><%- anticipo1_numero %></td>
    <td><%- anticipo1_fecha %></td>
    <% if( call == 'ajustesc' ) { %> 
    	<td><input type="checkbox" id="debito_<%- id %>" name="debito_<%- id %>" class="change-naturalezaanti"></td>
    	<td><input type="checkbox" id="credito_<%- id %>" name="credito_<%- id %>" class="change-naturalezaanti"></td>
    <% } %>
    <td><%- window.Misc.currency( anticipo1_saldo ) %></td>
    <td><input type="text" id="pagar_<%- id %>" name="pagar_<%- id %>" class="form-control input-sm change-pagar-anti" data-currency-negative></td>
</script>

<script type="text/template" id="add-factura3-item-tpl"> 
    <td><%- factura3_cuota %></td>
    <td><%- factura3_vencimiento %></td>
    <td><%- window.Misc.currency(factura3_valor) %></td>
    <td><%- window.Misc.currency(factura3_saldo) %></td>
</script>

<script type="text/template" id="add-conceptonota-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="conceptonota_nombre" class="control-label">Nombre</label>
			<input type="text" id="conceptonota_nombre" name="conceptonota_nombre" value="<%- conceptonota_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-sm-6 col-md-2">
			<label for="conceptonota_plancuentas" class="control-label text-right">Cuenta</label>
      		<div class="input-group input-group-sm">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="conceptonota_plancuentas">
						<i class="fa fa-tasks"></i>
					</button>
				</span>
				<input id="conceptonota_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="conceptonota_plancuentas" type="text" maxlength="15" data-wrapper="conceptonota-create" data-name="cuenta_nombre" value="<%- plancuentas_cuenta %>">
			</div>
		</div>
		<div class="col-sm-6 col-md-4"><br>
			<input id="cuenta_nombre" name="cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" disabled>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptonota_activo">
				<input type="checkbox" id="conceptonota_activo" name="conceptonota_activo" value="conceptonota_activo" <%- parseInt(conceptonota_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
	</div>
</script>

<script type="text/template" id="add-seriesprodbode-tpl">
    <table id="prodbod-search-table" class="table table-striped">
        <tbody>
            <tr>
               	<% if (edit){ %>
            		<th></th>
            	<% } %>
                <th>Serie</th>
                <th colspan="2">Nombre</th>
                <th>Sucursal</th>
            </tr>

            <% if( series == '') { %>
                <tr>
                    <th colspan="4" class="text-center">NO EXISTEN SERIES ASOCIADAS</th>
                </tr>
            <% } %>

            <% _.each(series, function(serie) { %>
                <tr>
               	<% if (edit){ %>
            		<td width="10%">
            			<label class="checkbox-inline" for="serie_hija_<%-serie.id %>">
							<input type="checkbox" id="serie_hija_<%-serie.id %>" name="serie_hija_<%-serie.id %>" value="<%- serie.id %>">
						</label>
					</td>
            	<% } %>
                    <td><%- serie.producto_serie %></td>
                    <td colspan="2"><%- serie.producto_nombre %></td>
                    <td><%- serie.sucursal_nombre %></td>
                </tr>
            <% }); %>
        </tbody>
</script>

<script type="text/template" id="add-conceptoajustec-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="conceptoajustec_nombre" class="control-label">Nombre</label>
			<input type="text" id="conceptoajustec_nombre" name="conceptoajustec_nombre" value="<%- conceptoajustec_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
    </div>
    <div class="row">
		<div class="form-group col-sm-6 col-md-2">
			<label for="conceptoajustec_plancuentas" class="control-label text-right">Cuenta</label>
      		<div class="input-group input-group-sm">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="conceptoajustec_plancuentas">
						<i class="fa fa-tasks"></i>
					</button>
				</span>
				<input id="conceptoajustec_plancuentas" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="conceptoajustec_plancuentas" type="text" maxlength="15" data-wrapper="conceptoajustec-create" data-name="cuenta_nombre" value="<%- plancuentas_cuenta %>">
			</div>
		</div>
		<div class="col-sm-6 col-md-4"><br>
			<input id="cuenta_nombre" name="cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" value="<%- plancuentas_nombre %>" maxlength="15" disabled>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptoajustec_activo">
				<input type="checkbox" id="conceptoajustec_activo" name="conceptoajustec_activo" value="conceptoajustec_activo" <%- parseInt(conceptoajustec_activo) ? 'checked': ''%>> Activo
			</label>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptoajustec_sumas_iguales">
				<input type="checkbox" id="conceptoajustec_sumas_iguales" name="conceptoajustec_sumas_iguales" value="conceptoajustec_sumas_iguales" <%- parseInt(conceptoajustec_sumas_iguales) ? 'checked': ''%>> Sumas igual
			</label>
		</div>
	</div>
</script>

{{-- templeates Tecnicos --}}
<script type="text/template" id="add-tipoorden-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="tipoorden_nombre" class="control-label">Nombre</label>
			<input type="text" id="tipoorden_nombre" name="tipoorden_nombre" value="<%- tipoorden_nombre %>" placeholder="Tipo de Orden" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="tipoorden_activo">
				<input type="checkbox" id="tipoorden_activo" name="tipoorden_activo" value="tipoorden_activo" <%- tipoorden_activo ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="add-conceptotec-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="conceptotec_nombre" class="control-label">Nombre</label>
			<input type="text" id="conceptotec_nombre" name="conceptotec_nombre" value="<%- conceptotec_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
		</div>
		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="conceptotec_activo">
				<input type="checkbox" id="conceptotec_activo" name="conceptotec_activo" value="conceptotec_activo" <%- parseInt(conceptotec_activo) ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="add-solicitante-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="solicitante_nombre" class="control-label">Nombre</label>
			<input type="text" id="solicitante_nombre" name="solicitante_nombre" value="<%- solicitante_nombre %>" placeholder="Solicitante" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="solicitante_activo">
				<input type="checkbox" id="solicitante_activo" name="solicitante_activo" value="solicitante_activo" <%- solicitante_activo ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
<script type="text/template" id="add-dano-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="dano_nombre" class="control-label">Nombre</label>
			<input type="text" id="dano_nombre" name="dano_nombre" value="<%- dano_nombre %>" placeholder="Daño" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="dano_activo">
				<input type="checkbox" id="dano_activo" name="dano_activo" value="dano_activo" <%- dano_activo ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>

<script type="text/template" id="add-prioridad-tpl">
	<div class="row">
		<div class="form-group col-md-8">
			<label for="prioridad_nombre" class="control-label">Nombre</label>
			<input type="text" id="prioridad_nombre" name="prioridad_nombre" value="<%- prioridad_nombre %>" placeholder="Prioridad" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>

		<div class="form-group col-md-2 col-xs-8 col-sm-3">
			<br><label class="checkbox-inline" for="prioridad_activo">
				<input type="checkbox" id="prioridad_activo" name="prioridad_activo" value="prioridad_activo" <%- prioridad_activo ? 'checked': ''%>> Activo
			</label>
		</div>
    </div>
</script>
<script type="text/template" id="add-tercero-cartera-tpl">
	<td>
		<% if(documentos_codigo == 'FACT'){ %>
			<a href="<%- window.Misc.urlFull( Route.route('facturas.show', {facturas: factura3_id} ))%>" title="Ver documento" target="_blank"><%- documentos_nombre %></a> 
		<% }else if(documentos_codigo == 'CHD') {%>
			<a href="<%- window.Misc.urlFull( Route.route('chequesdevueltos.show', {chequesdevueltos: factura3_id} ))%>" title="Ver documento" target="_blank"><%- documentos_nombre %></a> 
		<% }else if(documentos_codigo == 'ANTI'){ %>
			<a href="<%- window.Misc.urlFull( Route.route('anticipos.show', {anticipos: factura3_id} ))%>" title="Ver documento" target="_blank"><%- documentos_nombre %></a> 
		<% } %>
	</td>
	<td><%- factura1_numero %> </td>
    <td><%- sucursal_nombre %></td>
    <td><%- factura3_cuota %></td>
    <td><%- moment(factura1_fh_elaboro).format('YYYY-MM-DD') %></td>
	<td><%- factura3_vencimiento %></td>
	<td><%- days %></td>
    <td><%- window.Misc.currency(factura3_valor) %></td>
    <td><%- window.Misc.currency(factura3_saldo) %></td>
    <td>
    	<% if(factura3_chposfechado1 != null){ %>
    		<a href=" <%- window.Misc.urlFull( Route.route('cheques.show', {cheques: factura3_chposfechado1} ))%>" target="_blank" class="btn-default btn-xs" >CHP</a>
    	<% } %>  
    </td>
</script>
<script type="text/template" id="tfoot-tercero-deuda">
    <tr>
        <td colspan="6"></td>
        <th>Total</th>
        <th id="valor">0</th>
        <th id="total">0</th>
        <th></th>
    </tr>
    <tr>
        <th colspan="3" class="text-center">Acumulados</th>
        <th>Tipo</th>
        <th class="text-center">N</th>
        <th class="text-right">Valor T.</th>
        <th colspan="4"></th>
    </tr>
    <tr class="bg-table">
        <td colspan="3"></td>
        <td>Por vencer</td>
        <td class="text-center" id="porvencer">0</td>
        <td class="text-right" id="porvencer_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr class="bg-menor30">
        <td colspan="3"></td>
        <td>Menor a 30</td>
        <td class="text-center" id="menor30">0</td>
        <td class="text-right" id="menor30_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr class="bg-menor60">
        <td colspan="3"></td>
        <td>De 31 a 60</td>
        <td class="text-center" id="menor60">0</td>
        <td class="text-right" id="menor60_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr class="bg-menor90">
        <td colspan="3"></td>
        <td>De 61 a 90</td>
        <td class="text-center" id="menor90">0</td>
        <td class="text-right" id="menor90_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr class="bg-menor180">
        <td colspan="3"></td>
        <td>De 91 a 180</td>
        <td class="text-center" id="menor180">0</td>
        <td class="text-right" id="menor180_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr class="bg-menor360">
        <td colspan="3"></td>
        <td>De 181 a 360</td>
        <td class="text-center" id="menor360">0</td>
        <td class="text-right" id="menor360_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr class="bg-mayor360">
        <td colspan="3"></td>
        <td>Mayor a 360</td>
        <td class="text-center" id="mayor360">0</td>
        <td class="text-right" id="mayor360_saldo">0</td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <th>Total</th>
        <th class="text-center" id="total_count">0</th>
        <th class="text-right total">0</th>
        <td colspan="4"></td>
    </tr>
</script>
