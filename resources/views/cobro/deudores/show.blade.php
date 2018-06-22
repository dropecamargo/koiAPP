@extends('cobro.deudores.main')

@section('breadcrumb')
    <li><a href="{{ route('deudores.index')}}">Deudor</a></li>
    <li class="active">{{ $deudor->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="deudores-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-10">
                    <label class="control-label">Tercero</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $deudor->deudor_tercero ]) }}" title="Ver tercero">{{ $deudor->tercero_nit }} </a> - {{ $deudor->tercero_nombre }}</div>
                </div>

                <div class="form-group col-md-2">
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="#" class="open-gestiondeudor">
                                    <i class="fa fa-archive"></i>Generar gestión al deudor
                                </a>
                            </li>
                        </ul>
                    </li>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Nit</label>
                    <div>{{ $deudor->deudor_nit }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Digito</label>
                    <div>{{ $deudor->deudor_digito }}</div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Razón social</label>
                    <div>{{ $deudor->deudor_razonsocial }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">1er. Nombre</label>
                    <div>{{ $deudor->deudor_nombre1 }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">2do. Nombre</label>
                    <div>{{ $deudor->deudor_nombre2 }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">1er. Apellido</label>
                    <div>{{ $deudor->deudor_apellido1 }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">2do. Apellido</label>
                    <div>{{ $deudor->deudor_apellido2 }}</div>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('deudores.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="nav-tabs-custom tab-primary tab-whithout-box-shadow">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_documentos" data-toggle="tab">Documentos</a></li>
                            <li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
                        </ul>

                        <div class="tab-content">
                            {{-- Content areas --}}
                            <div class="tab-pane active" id="tab_documentos">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-documentos-deudor-list" class="table table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Tipo</th>
                                                        <th width="15%">Número</th>
                                                        <th width="10%">F. Expedición</th>
                                                        <th width="10%">F. Vencimiento</th>
                                                        <th width="10%">N. Dias</th>
                                                        <th width="10%">Cuota</th>
                                                        <th width="10%">Valor</th>
                                                        <th width="10%">Saldo</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     {{-- Render documentoscobro list --}}
                                                </tbody>
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_contactos">
                                <div class="box box-solid">
                                    <div class="row">
                                        <div class="col-sm-2 col-sm-offset-5 col-sm-8 col-xs-12">
                                            <button type="button" class="btn btn-primary btn-block btn-sm btn-add-contactodeudor" data-resource="contactodeudor" data-tercero="<%- id %>">
                                                <i class="fa fa-user-plus"></i>  Nuevo contacto
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="box-body">
                                            <!-- table table-bordered table-striped -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="browse-contactos-deudor-list" class="table table-bordered" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Dirección</th>
                                                            <th>Teléfono</th>
                                                            <th>Móvil</th>
                                                            <th>Correo</th>
                                                            <th>Cargo</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/template" id="add-contactodeudor-item-tpl">
        <td><%- contactodeudor_nombre %></td>
        <td><%- contactodeudor_direccion %></td>
        <td><%- contactodeudor_telefono %></td>
        <td><%- contactodeudor_movil %></td>
        <td><%- contactodeudor_email %></td>
        <td><%- contactodeudor_cargo %></td>
        <td class="text-center">
            <a class="btn btn-default btn-xs btn-edit-contactodeudor" data-resource="<%- id %>">
                <span><i class="fa fa-pencil-square-o"></i></span>
            </a>
        </td>
    </script>

    <!-- Modal add resource -->
    <div class="modal fade" id="modal-create-gestiondeudor-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    	<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content" id="content-gestiondeudor-component">
    			<div class="modal-header small-box {{ config('koi.template.bg') }}">
    				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    				<h4 class="inner-title-modal modal-title"></h4>
    			</div>
    			{!! Form::open(['id' => 'form-create-gestiondeudor-component', 'data-toggle' => 'validator']) !!}
    				<div class="modal-body">
    					<div id="error-gestiondeudor-resource-component" class="alert alert-danger"></div>
    					<div class="content-modal"></div>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
    					<button type="button" class="btn btn-primary btn-sm submit-gesiondeudor">Continuar</button>
    				</div>
    			{!! Form::close() !!}
    		</div>
    	</div>
    </div>

    <script type="text/template" id="create-gestiondeudoraction-tpl">
        <div class="row">
            <div class="form-group col-md-6">
                <select name="gestiondeudor_conceptocob" id="gestiondeudor_conceptocob" data-placeholder="Concepto de cobro" class="form-control select2-default" required>
                    @foreach( App\Models\Cartera\ConceptoCob::getConceptoCobro() as $key => $value)
                        <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group col-sm-3">
                <input id="gestiondeudor_proxima" name="gestiondeudor_proxima" class="form-control input-sm datepicker" placeholder="Fecha proxima" type="text" required>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group col-md-3">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="gestiondeudor_hproxima" name="gestiondeudor_hproxima" placeholder="Hora proxima" class="form-control input-sm timepicker" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <textarea id="gestiondeudor_observaciones" name="gestiondeudor_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
            </div>
        </div>
    </script>
@stop
