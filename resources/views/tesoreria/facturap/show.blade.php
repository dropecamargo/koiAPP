@extends('tesoreria.facturap.main')


@section('module')
	<section class="content-header">
        <h1>
            Facturas proveedor <small>Administración de facturas proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('facturasp.index') }}">Factura proveedor</a></li>
            <li class="active">{{ $facturap1->id }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-solid" id="facturap-show">
            <div class="nav-tabs-custom tab-warning tab-whithout-box-shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_facturap" data-toggle="tab">Factura</a></li>
                    <li><a href="#tab_impuesto" data-toggle="tab">Impuesto/Retención</a></li>
                    <li><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
                    <li><a href="#tab_af" data-toggle="tab">Activos fijos</a></li>
                    <li><a href="#tab_inventario" data-toggle="tab">Inventario</a></li>
                    <li class="pull-right">
                        <button type="button" class="btn btn-block btn-danger btn-sm export-facturap">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <!-- Tab factura proveedor -->
                <div id="tab_facturap" class="tab-pane active">
                    <div class="box-body">
                        <div class="row">
                            <label for = "facturap1_regional" class="control-label col-md-1">Regional</label>
                            <div class="form-group col-md-3">
                                {{ $facturap1->regional_nombre }}
                            </div>
                            <label for="facturap1_numero" class="col-md-1 control-label">Número</label>
                            <div class="form-group col-md-1">
                                {{ $facturap1->facturap1_numero }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_tercero" class="col-md-1 control-label">Cliente</label>
                            <div class="form-group col-md-3">
                                {{ $facturap1->tercero_nombre }}
                            </div>
                            <label for="facturap1_tercero" class="col-md-1 control-label">Persona</label>
                            <div class="form-group col-md-2">
                                {{ ($facturap1->tercero_persona == 'N') ? 'NATURAL' : 'JURIDICA' }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_factura" class="control-label col-md-1">Factura</label>
                            <div class="form-group col-md-3">
                                {{$facturap1->facturap1_factura }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_fecha" class="col-md-1 control-label">Fecha</label>
                            <div class="form-group col-md-3">
                                {{$facturap1->facturap1_fecha }}
                            </div>

                            <label for="facturap1_vencimiento" class="control-label col-md-1">Vencimiento</label>
                            <div class="form-group col-md-2">
                                {{$facturap1->facturap1_vencimiento }}
                            </div>
                            <label for="facturap1_primerpago" class="control-label col-md-1">Primer pago</label>
                            <div class="form-group col-md-2">
                                {{$facturap1->facturap1_primerpago }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_tipoproveedor" class="control-label col-md-1">Tipo proveedor</label>
                            <div class="form-group col-md-3">
                                {{ $facturap1->tipoproveedor_nombre }}
                            </div>
                            <label for="facturap1_tipogasto" class="control-label col-md-1">Tipo gasto</label>
                            <div class="form-group col-md-2">
                                {{ $facturap1->tipogasto_nombre }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_cuotas" class="control-label col-md-1">Cuota</label>
                            <div class="form-group col-md-3">
                                {{$facturap1->facturap1_cuotas }}
                            </div>
                            <label for="facturap1_subtotal" class="control-label col-md-1">Subtotal</label>
                            <div class="form-group col-md-2">
                                {{number_format( $facturap1->facturap1_subtotal ) }}
                            </div>
                            <label for="facturap1_descuento" class="control-label col-md-1">Descuento</label>
                            <div class="form-group col-md-2">
                                {{number_format( $facturap1->facturap1_descuento ) }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_impuestos" class="control-label col-md-1">Impuestos</label>
                            <div class="form-group col-md-3">
                                {{ number_format($facturap1->facturap1_impuestos) }}
                            </div>
                            <label for="facturap1_retenciones" class="control-label col-md-1">Retenciones</label>
                            <div class="form-group col-md-2">
                                {{ number_format( $facturap1->facturap1_retenciones ) }}
                            </div>
                            <label for="facturap1_apagar" class="control-label col-md-1">A pagar</label>
                            <div class="form-group col-md-2">
                                {{ number_format( $facturap1->facturap1_apagar ) }}
                            </div>
                        </div>
                        <div class="row">
                            <label for="facturap1_observaciones" class="col-md-1 control-label">Observaciones</label>
                            <div class="form-group col-md-10">
                                {{$facturap1->facturap1_observaciones }}
                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-body table-responsive">
                                <table id="browse-facturap3-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Cuota</th>
                                            <th>Vencimiento</th>
                                            <th>Valor</th>
                                            <th>Saldo</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        {{-- Render factura3 list --}}
                                   </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <th>Total</th>
                                            <th id="valor">0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab impuesto -->
                <div id="tab_impuesto" class="tab-pane">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="table-responsive no-padding">
                                <table id="browse-detalle-facturap2-list" class="table table-hover table-bordered table-condensed" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="40%">Nombre</th>
                                            <th width="30%">%</th>
                                            <th width="30%">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content detalle facturap2 --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab contabilidad -->
                <div id="tab_contabilidad" class="tab-pane">
                    Contabilidad
                </div>
                <!-- Tab activos & efectivos -->
                <div id="tab_af"  class="tab-pane">
                    <div class="box box-solid">
                        <div class="box-body">
                             <div class="table-responsive no-padding">
                                <table id="browse-activo-fijo-list" class="table table-hover table-bordered table-condensed" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="15%">Placa</th>
                                            <th width="15%">Serie</th>
                                            <th width="40%">Responsable</th>
                                            <th width="20%">Tipo</th>
                                            <th width="10%">Costo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content activo fijo --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab inventory -->
                <div id="tab_inventario" class="tab-pane">
                    <div class="box box-solid">
                        <div class="box-body">
                            @if ($facturap1->facturap1_entrada1 != null)
                                <div class="row">
                                    <label class="control-label col-md-1">Sucursal</label>
                                    <div class="form-group col-md-3"> {{ $facturap1->sucursal_nombre }}</div>

                                    <label class="control-label col-md-1">Número</label>
                                    <div class="form-group col-md-1"> {{ $facturap1->entrada1_numero }}</div>

                                    <label class="control-label col-md-1">Fecha</label>
                                    <div class="form-group col-md-1"> {{ $facturap1->entrada1_fecha }}</div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-md-1">Subtotal</label>
                                    <div class="form-group col-md-1"> {{ number_format($facturap1->entrada1_subtotal) }}</div>

                                    <label class="control-label col-md-1">Descuento</label>
                                    <div class="form-group col-md-1"> {{ number_format($facturap1->entrada1_descuento) }}</div>

                                    <label class="control-label col-md-1">Iva</label>
                                    <div class="form-group col-md-1"> {{ $facturap1->entrada1_iva }}</div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-md-1">Observaciones</label>
                                    <div class="form-group col-md-1"> {{ $facturap1->entrada1_observaciones }}</div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-md-1">Elaboró</label>
                                    <div class="form-group col-md-3"> {{ $facturap1->entrada1_elaboro }} - {{ $facturap1->entrada1_nit }}</div>
                                </div>
                                <div class="table-responsive no-padding">
                                    <table id="browse-entrada2-treasury-list" class="table table-hover table-bordered table-condensed" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="20%">Referencia</th>
                                                <th width="40%">Nombre</th>
                                                <th>Cantidad</th>
                                                <th>Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Render content detail entrada --}}
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="box-title">
                                    <h4 class="text-center">No existe entrada de inventario en la factura proveedor número {{$facturap1->facturap1_numero}}</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5 col-md-6 col-xs-6">
                            <a href="{{ route('facturasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="box box-solid">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						<h4><a href="{{ route('asientos.show', ['asientos' =>  $facturap1->facturap1_asiento ]) }}" target="_blanck" title="Ver Asiento"> Ver asiento contable </a></h4>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<h4><b>Caja Menor N° {{$facturap1->facturap1_numero}} </b></h4>
					</div>
				</div>
			</div>
		</div>
    </section>
    <script type="text/template" id="show-facturap-cuota-tpl">
        <td><%- facturap3_cuota %></td>
        <td><%-  facturap3_vencimiento %></td>
        <td><%- window.Misc.currency(facturap3_valor) %></td>
        <td><%- window.Misc.currency(facturap3_saldo) %></td>
    </script>

    <script type="text/template" id="show-entrada-detail-tpl">
        <td><%- producto_serie %></td>
        <td><%- producto_nombre %></td>
        <td><%- entrada2_cantidad %></td>
        <td><%- entrada2_costo %></td>
    </script>
@stop
