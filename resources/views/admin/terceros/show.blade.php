@extends('admin.terceros.main')

@section('breadcrumb')
	<li><a href="{{ route('terceros.index') }}">Terceros</a></li>
	<li class="active">{{ $tercero->tercero_nit }}</li>
@stop

@section('module')
<div class="box box-solid">
    <div class="nav-tabs-custom tab-primary tab-whithout-box-shadow">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_tercero" data-toggle="tab">Tercero</a></li>
            <li><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
			<li><a href="#tab_empleados" data-toggle="tab" class="{{ $tercero->tercero_empleado || $tercero->tercero_interno ? '' : 'hide' }}">Empleado</a></li>
			<li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="tab_tercero">
        	<div class="box box-solid">
                <div class="box-body">
					<div class="row">
                    	<div class="form-group col-md-2">
							<label class="control-label">Documento</label>
							<div>{{ $tercero->tercero_nit }} - {{ $tercero->tercero_digito }}</div>
						</div>
                    	<div class="form-group col-md-3">
							<label class="control-label">Tipo</label>
							<div>{{ $tercero->tercero_tipo ? config('koi.terceros.tipo')[$tercero->tercero_tipo] : ''  }} </div>
						</div>
					</div>

					<div class="row">
						@if($tercero->tercero_persona == 'J')
							<div class="form-group col-md-2">
								<label class="control-label">Razón Social o Comercial</label>
								<div>{{ $tercero->tercero_razonsocial }}</div>
							</div>
						@else
						<div class="form-group col-md-2">
							<label class="control-label">1er. Nombre</label>
							<div>{{ $tercero->tercero_nombre1 }}</div>
						</div>

						<div class="form-group col-md-2">
							<label class="control-label">2do. Nombre</label>
							<div>{{ $tercero->tercero_nombre2 }}</div>
						</div>

						<div class="form-group col-md-2">
							<label class="control-label">1er. Apellido</label>
							<div>{{ $tercero->tercero_apellido1 }}</div>
						</div>

						<div class="form-group col-md-2">
							<label class="control-label">2do. Apellido</label>
							<div>{{ $tercero->tercero_apellido2 }}</div>
						</div>
						@if($tercero->tercero_familia != "")
							<div class="form-group col-md-2">
								<label class="control-label">Familia</label>
								<div>{{ $tercero->tercero_familia }}</div>
							</div>
						@endif
					</div>
					<div class="row">
						<div class="form-group col-md-2">
							<label class="control-label">Establecimiento</label>
							<div>{{ $tercero->tercero_razonsocial }}</div>
						</div>
						@endif

						<div class="form-group col-md-4">
							<label class="control-label">Dirección</label> <small>{{ $tercero->tercero_dir_nomenclatura }}</small>
							<div>{{ $tercero->tercero_direccion }}</div>
						</div>
						<div class="form-group col-md-2">
							<label class="control-label">Municipio</label>
							<div>{{ $tercero->municipio_nombre }}</div>
						</div>
						@if($tercero->tercero_pais != "")
							<div class="form-group col-md-2">
								<label class="control-label">País</label>
								<div>{{ $tercero->pais_nombre }}</div>
							</div>
						@endif
                    </div>
            	</div>
				<div class="box-footer">
					<div class="row">
						<div class="col-md-offset-4 col-md-2 col-sm-6 col-xs-6">
							<a href="{{ route('terceros.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-6">
							<a href="{{ route('terceros.edit', ['terceros' => $tercero->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
						</div>
					</div>
				</div>
        	</div>


			<div class="box box-solid collapsed-box">
                <div class="box-header">
                    <h1 class="box-title ">Informacion Adicional</h1>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<div class="row">
						<div class="form-group col-md-3">
							<label class="control-label">Regimen</label>
							<div>{{ $tercero->tercero_regimen ? config('koi.terceros.regimen')[$tercero->tercero_regimen] : ''  }} </div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">Persona</label>
							<div>{{ $tercero->tercero_persona ? config('koi.terceros.persona')[$tercero->tercero_persona] : ''  }} </div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">Municipio</label>
							<div><small>{{ $tercero->municipio_nombre }}</small></div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">Email</label>
							<div>{{ $tercero->tercero_email }}</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<label class="control-label">Teléfono</label>
							<div><i class="fa fa-phone"></i> {{ $tercero->tercero_telefono1 }}</div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">2do. Teléfono</label>
							<div><i class="fa fa-phone"></i> {{ $tercero->tercero_telefono2 }}</div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">Fax</label>
							<div><i class="fa fa-fax"></i> {{ $tercero->tercero_fax }}</div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">Celular</label>
							<div><i class="fa fa-mobile"></i> {{ $tercero->tercero_celular }}</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label class="control-label">Representante Legal</label>
							<div>{{ $tercero->tercero_representante }}</div>
						</div>

						<div class="form-group col-md-3">
							<label class="control-label">Cédula</label>
							<div>{{ $tercero->tercero_cc_representante }}</div>
						</div>
			        </div>
                </div>
            </div>

            <div class="nav-tabs-custom tab-primary tab-whithout-box-shadow">
	            <ul class="nav nav-tabs">
					<li class="active"><a href="#tab_cartera" data-toggle="tab">Cartera</a></li>
					<li><a href="#tab_proveedor" data-toggle="tab">Proveedor</a></li>
					<li><a href="#tab_gestioncobro" data-toggle="tab">Gestión Cobro</a></li>
					<li><a href="#tab_gestioncomercial" data-toggle="tab">Gestión Comercial</a></li>
					<li><a href="#tab_gestiontecnica" data-toggle="tab">Gestión Técnica</a></li>
				</ul>
			</div>

			<div class="tab-content">
	            <div class="tab-pane active" id="tab_cartera">
					<div class="box-body">
						<div class="box-body table-responsive">
							<table id="browse-factura3-list" class="table table-bordered table-condensed" cellspacing="0" width="100%">
					            <thead>
						            <tr>
		                                <th>Documento</th>
		                                <th>Numero</th>
		                                <th>Sucursal</th>
		                                <th>Cuota</th>
		                                <th>Fecha</th>
		                                <th>Vencimiento</th>
		                                <th>N. Dias</th>
		                                <th>Valor</th>
		                                <th>Saldo</th>
		                                <th></th>
		                            </tr>
					           </thead>
					           <tbody>
									{{-- Render facura3 list --}}
					           </tbody>
					           <tfoot>

					           </tfoot>
						    </table>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_proveedor">
					<div class="box-body table-responsive">
						<table id="browse-facturap3-list" class="table table-bordered" cellspacing="0">
						    <thead>
					            <tr>
					            	<th>Tipo</th>
	                                <th width="10%">Numero</th>
	                                <th width="20%">Regional</th>
	                                <th width="5%">Cuota</th>
	                                <th width="15%">Vencimiento</th>
	                                <th width="5%">Dias</th>
	                                <th width="15%">Valor</th>
	                                <th width="15%">Saldo</th>
	                            </tr>
				           </thead>
							<tbody>
								{{--Render proveedor-factura--}}
							</tbody>
							<tfoot>
							   <tr>
									<td colspan="6"></td>
									<th>Total</th>
									<th id="valor">0</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab_gestioncobro">
					<div class="box-body table-responsive">
						<table id="browse-gestioncobro-list" class="table table-bordered" cellspacing="0">
							<thead>
								<tr>
									<th width="15%">Concepto</th>
									<th width="15%">Fecha</th>
									<th width="15%">Fecha Próxima</th>
									<th width="35%">Observaciones</th>
									<th width="20%">Elaboró</th>
								</tr>
							</thead>
							<tbody>
								{{--Render gestion cobro--}}
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab_gestioncomercial">
					<div class="box-body table-responsive">
						<table id="browse-gestioncomercial-list" class="table table-bordered" cellspacing="0">
							<thead>
								<tr>
									<th width="15%">Concepto</th>
									<th width="15%">Fecha Inicio</th>
									<th width="15%">Fecha Final</th>
									<th width="35%">Observaciones</th>
									<th width="20%">Elaboró</th>
								</tr>
							</thead>
							<tbody>
								{{--Render gestion comercial--}}
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab_gestiontecnica">
					<div class="box-body table-responsive">
						<table id="browse-gestiontecnica-list" class="table table-bordered" cellspacing="0">
							<thead>
								<tr>
									<th width="15%">Concepto</th>
									<th width="15%">Fecha</th>
									<th width="15%">Fecha Próxima</th>
									<th width="35%">Observaciones</th>
									<th width="20%">Elaboró</th>
								</tr>
							</thead>
							<tbody>
								{{--Render gestion tecnica--}}
							</tbody>
						</table>
					</div>
				</div>
			</div>
        </div>

		<div class="tab-pane" id="tab_contabilidad">
        	<div class="box-body">
	        	<div class="row">
		        	<div class="form-group col-md-8 col-md-offset-1">
		        		<label class="control-label">Actividad Económica</label>
		        		<div>{{ $tercero->actividad_codigo }} - {{ $tercero->actividad_nombre }}</div>
		        	</div>
		        	<div class="form-group col-md-2">
		        		<label class="control-label">% Cree</label>
		        		<div>{{ $tercero->actividad_tarifa }}</div>
		        	</div>
		        </div>

    	        <div class="row"><br>
		        	<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_cliente">
							<input type="checkbox" id="tercero_cliente" name="tercero_cliente" value="tercero_cliente" disabled {{ $tercero->tercero_cliente ? 'checked': '' }}> Cliente
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_acreedor">
							<input type="checkbox" id="tercero_acreedor" name="tercero_acreedor" value="tercero_acreedor" disabled {{ $tercero->tercero_acreedor ? 'checked': '' }}> Acreedor
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_proveedor">
							<input type="checkbox" id="tercero_proveedor" name="tercero_proveedor" value="tercero_proveedor" disabled {{ $tercero->tercero_proveedor ? 'checked': '' }}> Proveedor
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_autoretenedor_ica">
							<input type="checkbox" id="tercero_autoretenedor_ica" name="tercero_autoretenedor_ica" value="tercero_autoretenedor_ica" disabled {{ $tercero->tercero_autoretenedor_ica ? 'checked': '' }}> Autorretenedor ICA
						</label>
					</div>

					<div class="form-group col-md-3">
						<label class="checkbox-inline" for="tercero_responsable_iva">
							<input type="checkbox" id="tercero_responsable_iva" name="tercero_responsable_iva" value="tercero_responsable_iva" disabled {{ $tercero->tercero_responsable_iva ? 'checked': '' }}> Responsable de IVA
						</label>
					</div>
		        </div>

		        <div class="row">
		        	<div class="form-group col-md-2">
				    	<label class="checkbox-inline" for="tercero_empleado">
							<input type="checkbox" id="tercero_empleado" name="tercero_empleado" value="tercero_empleado" disabled {{ $tercero->tercero_empleado ? 'checked': '' }}> Empleado
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_interno">
							<input type="checkbox" id="tercero_interno" name="tercero_interno" value="tercero_interno" disabled {{ $tercero->tercero_interno ? 'checked': '' }}> Interno
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_extranjero">
							<input type="checkbox" id="tercero_extranjero" name="tercero_extranjero" value="tercero_extranjero" disabled {{ $tercero->tercero_extranjero ? 'checked': '' }}> Extranjero
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_afiliado">
							<input type="checkbox" id="tercero_afiliado" name="tercero_afiliado" value="tercero_afiliado" disabled {{ $tercero->tercero_afiliado ? 'checked': '' }}> Afiliado
						</label>
					</div>

					<div class="form-group col-md-3">
						<label class="checkbox-inline" for="tercero_autoretenedor_cree">
							<input type="checkbox" id="tercero_autoretenedor_cree" name="tercero_autoretenedor_cree" value="tercero_autoretenedor_cree" disabled {{ $tercero->tercero_autoretenedor_cree ? 'checked': '' }}> Autorretenedor CREE
						</label>
					</div>
		        </div>

				<div class="row">
					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_socio">
							<input type="checkbox" id="tercero_socio" name="tercero_socio" value="tercero_socio" disabled {{ $tercero->tercero_socio ? 'checked': '' }}> Socio
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_mandatario">
							<input type="checkbox" id="tercero_mandatario" name="tercero_mandatario" value="tercero_mandatario" disabled {{ $tercero->tercero_mandatario ? 'checked': '' }}> Mandatario
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_gran_contribuyente">
							<input type="checkbox" id="tercero_gran_contribuyente" name="tercero_gran_contribuyente" value="tercero_gran_contribuyente" disabled {{ $tercero->tercero_gran_contribuyente ? 'checked': '' }}> Gran contribuyente
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_autoretenedor_renta">
							<input type="checkbox" id="tercero_autoretenedor_renta" name="tercero_autoretenedor_renta" value="tercero_autoretenedor_renta" disabled {{ $tercero->tercero_autoretenedor_renta ? 'checked': '' }}> Autorretenedor renta
						</label>
					</div>

					<div class="form-group col-md-2">
						<label class="checkbox-inline" for="tercero_otro">
							<input type="checkbox" id="tercero_otro" name="tercero_otro" value="tercero_otro" disabled {{ $tercero->tercero_otro ? 'checked': '' }}> Otro
						</label>
					</div>

					<div class="form-group col-md-2">
						<div>{{ $tercero->tercero_cual }}</div>
					</div>
			    </div>
			</div>
		</div>


		{{-- Tab empleados --}}
		<div class="tab-pane" id="tab_empleados">
			<div class="box-body"><br>
				<form method="POST" accept-charset="UTF-8" id="form-employee" data-toggle="validator">
					<div class="row">
			    		<div class="form-group col-md-4">
							<div class="row">
						    	<div class="form-group col-md-4">
					        		<label class="checkbox-inline" for="tercero_activo">
										<input type="checkbox" id="tercero_activo" name="tercero_activo" value="tercero_activo" disabled {{ $tercero->tercero_activo ? 'checked': '' }}> Activo
									</label>
					        	</div>
					        	<div class="form-group col-md-4">
					        		<label class="checkbox-inline" for="tercero_tecnico">
										<input type="checkbox" id="tercero_tecnico" name="tercero_tecnico" value="tercero_tecnico" disabled {{ $tercero->tercero_tecnico ? 'checked': '' }}> Técnico
									</label>
					        	</div>
							</div>

							<div class="row">
								<div class="form-group col-md-4">
					        		<label class="checkbox-inline" for="tercero_coordinador">
										<input type="checkbox" id="tercero_coordinador" name="tercero_coordinador" value="tercero_coordinador" disabled {{ $tercero->tercero_coordinador ? 'checked': '' }}> Coordinador
									</label>
					        	</div>
					        	<div class="form-group col-md-4">
					        		<label class="checkbox-inline" for="tercero_vendedor">
										<input type="checkbox" id="tercero_vendedor" name="tercero_vendedor" value="tercero_vendedor" disabled {{ $tercero->tercero_vendedor ? 'checked': '' }}> Vendedor
									</label>
					        	</div>
					        </div>
					    </div>

			    		<div class="form-group col-md-6">
							<div class="row">
		                       	<div class="form-group col-md-6 {{ $tercero->tercero_tecnico || $tercero->tercero_vendedor ? '' : 'hide' }}">
									<label for="tercero_coordinador_por" class="control-label">Coordinado por</label>
									<div>{{ $tercero->nombre_coordinador }}</div>
		                        </div>

		                        <div class="form-group col-md-6">
									<label for="tercero_sucursal" class="control-label">Sucursal</label>
									<div>{{ $tercero->sucursal_nombre }}</div>
		                        </div>
							</div>
						</div>
					</div>
				</form>

				<br />
				<div class="row">
			    	<div class="form-group col-md-offset-2 col-md-8">
						<div class="box box-primary" id="wrapper-roles">
							<div class="box-header with-border">
								<h3 class="box-title">Roles de usuario</h3>
							</div>
		                    <div class="box-body table-responsive no-padding">
		                        <table id="browse-roles-list" class="table table-bordered" cellspacing="0">
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
			<div class="box-body">
				<div class="box-body table-responsive no-padding">
					<table id="browse-contact-list" class="table table-bordered" cellspacing="0" width="100%">
			            <thead>
				            <tr>
				                <th>Nombre</th>
				                <th>Email</th>
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
</div>
@stop
