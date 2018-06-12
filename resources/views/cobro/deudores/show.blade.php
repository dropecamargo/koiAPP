@extends('cobro.deudores.main')

@section('breadcrumb')
    <li><a href="{{ route('deudores.index')}}">Deudor</a></li>
    <li class="active">{{ $deudor->id }}</li>
@stop

@section('module')
    <div class="box box-primary" id="deudores-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Tercero</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $deudor->deudor_tercero ]) }}" title="Ver tercero">{{ $deudor->tercero_nit }} </a> - {{ $deudor->tercero_nombre }}</div>
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

    <script type="text/template" id="add-documentocobro-item-tpl">
        <td colspan="2"><%- documentocobro_tipo %></td>
        <td><%- documentocobro_numero %></td>
        <td><%- documentocobro_expedicion %></td>
        <td><%- documentocobro_vencimiento %></td>
        <td><%- days %></td>
        <td class="text-center"><%- documentocobro_cuota %></td>
        <td class="text-right"><%- window.Misc.currency( documentocobro_valor ) %></td>
        <td class="text-right"><%- window.Misc.currency( documentocobro_saldo ) %></td>
        <th></th>
    </script>

    <script type="text/template" id="add-contactodeudor-item-tpl">
        <td><%- contactodeudor_nombre %></td>
        <td><%- contactodeudor_direccion %></td>
        <td><%- contactodeudor_telefono %></td>
        <td><%- contactodeudor_movil %></td>
        <td><%- contactodeudor_email %></td>
        <td><%- contactodeudor_cargo %></td>
    </script>
@stop
