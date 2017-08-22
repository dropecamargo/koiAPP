@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="10%">Fecha</th>
				<td width="15%">{{ $facturap->facturap1_fecha }}</td>
				<th width="10%">Vencimiento</th>
				<td width="15%">{{ $facturap->facturap1_vencimiento }}</td>
				<th width="10%">Primer pago</th>
				<td width="15%">{{ $facturap->facturap1_primerpago }}</td>
			</tr>
			<tr>
				<th width="15%">Regional</th>
				<td colspan="5">{{ $facturap->regional_nombre }}</td>
			</tr>
			<tr>
				<th width="15%">Tercero</th>
				<td colspan="5">{{ $facturap->tercero_nombre }} - {{ $facturap->tercero_nit }}</td>
			</tr>
			<tr>
				<th width="15%">Cuota</th>
				<td width="5%">{{ $facturap->facturap1_cuotas }}</td>
				<th width="15%">Subtotal</th>
				<td>{{ number_format($facturap->facturap1_subtotal,2,',','.') }}</td>
				<th width="15%">Descuento</th>
				<td>{{ number_format($facturap->facturap1_descuento,2,',','.') }}</td>
			</tr>
			<tr>
				<th width="15%">Base</th>
				<td>{{ number_format($facturap->facturap1_base,2,',','.') }}</td>
				<th width="15%">Impuestos</th>
				<td>{{ number_format($facturap->facturap1_impuestos,2,',','.') }}</td>
				<th width="15%">A pagar</th>
				<td>{{ number_format($facturap->facturap1_apagar,2,',','.') }}</td>
			</tr>
			<tr>
				<th width="15%">Tipo gasto</th>
				<td colspan="2">{{ $facturap->tipogasto_nombre }}</td>
				<th width="15%">Tipo proveedor</th>
				<td colspan="2">{{ $facturap->tipoproveedor_nombre }}</td>
			</tr>
			<tr>
				<th width="15%">Factura</th>
				<td colspan="5">{{ $facturap->facturap1_factura }} </td>
			</tr>

			<tr>
				<th width="15%">Observaciones</th>
				<td colspan="5">{{ $facturap->facturap1_observaciones }}</td>
			</tr>
		</tbody>
	</table>
    <br>

	@if (count($facturap2) > 0)
		<table class="tbtitle">
			<thead>
				<tr><td class="titleespecial">Impuesto/Retenciones</td></tr>
			</thead>
		</table>

		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	        <thead>
		        <tr>
		            <th>Nombre</th>
		            <th>%</th>
		            <th>Valor</th>
		        </tr>
	       	<thead>
	       	<tbody>
				@foreach ($facturap2 as $item)
					<tr>
						<td>{{ ($item->impuesto_nombre != null ) ? $item->impuesto_nombre : $item->retefuente_nombre }}</td>
						<td>{{ $item->facturap2_porcentaje }}</td>
						<td>{{ number_format($item->facturap2_base ,2,',','.') }}</td>
					</tr>
				@endforeach
	       	</tbody>
		</table>
		<br>
	@endif

<!-- 	<table class="tbtitle">
		<thead>
			<tr><td class="titleespecial">Contabilidad</td></tr>
		</thead>
	</table> -->
	@if (count($activofijo) > 0)
		<table class="tbtitle">
			<thead>
				<tr><td class="titleespecial">Activos fijos</td></tr>
			</thead>
		</table>

		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	        <thead>
		        <tr>
		            <th>Placa</th>
		            <th>Serie</th>
		            <th>Responsable</th>
		            <th>Tipo</th>
		            <th>Costo</th>
		        </tr>
	       	<thead>
	       	<tbody>
				@foreach ($activofijo as $item)
					<tr>
						<td>{{ $item->activofijo_placa }}</td>
						<td>{{ $item->activofijo_serie }}</td>
						<td>{{ $item->tercero_nombre }}</td>
						<td>{{ $item->tipoactivo_nombre }}</td>
						<td>{{ number_format($item->activofijo_costo ,2,',','.') }}</td>
					</tr>
				@endforeach
	       	</tbody>
		</table>
		<br>
	@endif
    @if ($facturap->facturap1_entrada1 != null)
		<table class="tbtitle">
			<thead>
				<tr><td class="titleespecial">Inventario/Entrada</td></tr>
			</thead>
		</table>

		<table class="htable" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<th width="15%">Sucursal</th>
					<td> {{ $facturap->sucursal_nombre }} </td>
					<th width="15%">Numero</th>
					<td>{{ $facturap->entrada1_numero }}</td>
					<th width="15%">Fecha</th>
					<td>{{ $facturap->entrada1_fecha }}</td>
				</tr>
				<tr>
					<th width="15%">Subtotal</th>
					<td>{{ number_format($facturap->entrada1_subtotal,2,',','.') }}</td>
					<th width="15%">Descuento</th>
					<td>{{ number_format($facturap->entrada1_descuento,2,',','.') }}</td>
					<th width="15%">Iva</th>
					<td>{{ $facturap->entrada1_iva }}</td>
				</tr>
				<tr>
					<th width="15%">Observaciones</th>
					<td colspan="5">{{ $facturap->entrada1_observaciones }}</td>
				</tr>
			</tbody>
		</table>
		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	        <thead>
		        <tr>
		            <th>Referencia</th>
		            <th>Nombre</th>
		            <th>Cantidad</th>
		            <th>Costo</th>
		        </tr>
	       	<thead>
	       	<tbody>
				@foreach ($entrada2 as $item)
					<tr>
						<td>{{ $item->producto_serie }}</td>
						<td>{{ $item->producto_nombre }}</td>
						<td>{{ $item->entrada2_cantidad }}</td>
						<td>{{ number_format($item->entrada2_costo ,2,',','.') }}</td>
					</tr>
				@endforeach
	       	</tbody>
	       	<tfoot>
	       		<tr>
	       			<th class="right" colspan="2"> Elaboró </th>
	       			<td colspan="2">&nbsp;{{ $facturap->entrada1_elaboro }} - {{ $facturap->entrada1_nit }}</td>
	       		</tr>
	       	</tfoot>
		</table>
	@endif
    <div class="center foot">
        <b>Fecha de impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop