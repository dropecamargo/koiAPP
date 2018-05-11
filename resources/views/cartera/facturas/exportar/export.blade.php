@extends('cartera.facturas.exportar.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="bordered">
		<thead>
			<tr>
				<th>Fecha de facturación</th>
				<td>{{ $factura->factura1_fecha }}</td>
				<th>Factura de vencimiento</th>
				<td>{{ $factura->factura1_fecha }}</td>
				<th>FACTURA DE VENTA N°</th>
				<td>{{ $factura->factura1_numero }}</td>
			</tr>
			<tr>
				<th>Señor (es)</th>
				<td colspan="3">{{ $factura->tercero_nombre }}</td>
				<th>Nit</th>
				<td>{{ $factura->tercero_nit }}</td>
			</tr>
			<tr>
				<th>Dirección</th>
				<td colspan="3">{{ $factura->tercero_direccion }}</td>
				<th>Tel</th>
				<td>
					@if( !empty($factura->tercero_telefono1) )
						{{ $factura->tercero_telefono1 }}
					@elseif ( !empty($factura->tercero_telefono2) )
						{{ $factura->tercero_telefono2 }}
					@elseif ( !empty($factura->tercero_celular) )
						{{ $factura->tercero_celular }}
					@endif
				</td>
			</tr>
			<tr>
				<td colspan="6"> {{ $factura->puntoventa_resolucion_dian }}</td>
			</tr>
		</thead>
	</table>&nbsp;
	<table class="bordered">
		<thead>
			<tr>
				<th width="10%" class="center border-bottom border-right">CANT</th>
				<th width="60%" class="center border-bottom border-right">DESCRIPCIÓN</th>
				<th width="15%" class="center border-bottom border-right">VR. UNITARIO</th>
				<th width="15%" class="center border-bottom">TOTAL</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $rows = count($detalle); /*--}}
			@if($rows > 0)
				@foreach($detalle as $item)
					<tr>
						<td class="center border-bottom">{{ $item->factura2_cantidad }}</td>
						<td class="left border-bottom border-left">{{ $item->producto_serie }} - {{ $item->producto_nombre }}</td>
						<td class="right border-bottom border-left">{{ number_format($item->factura2_costo,2,',','.') }}&nbsp;</td>
						<td class="right border-bottom border-left">{{ number_format($item->factura2_costo * $item->factura2_cantidad,2,',','.') }}&nbsp;</td>
					</tr>
					@foreach(App\Models\Cartera\Factura4::getComments($item->id) as $value)
						{{--*/ $rows ++ /*--}}
						<tr>
							<td class="center border-bottom"></td>
							<td class="left border-bottom border-left comment">{{ $value->factura4_comment }}</td>
							<td class="right border-bottom border-left"></td>
							<td class="right border-bottom border-left"></td>
						</tr>
					@endforeach
				@endforeach
			@endif
			@for($rows; $rows < 22 ; $rows++)
				<tr>
					<td class="border-bottom"></td>
					<td class="border-bottom border-left"></td>
					<td class="border-bottom border-left"></td>
					<td class="border-bottom border-left"></td>
				</tr>
			@endfor
		</tbody>
		<tfoot>
			<tr>
				<td rowspan="4" colspan="2" class="bold">{{ NumeroALetras::convertir($factura->factura1_total-$factura->factura1_retencion, 'pesos', 'centavos') }}</td>
				<th class="right border-bottom border-left">SUB-TOTAL &nbsp;</th>
				<th class="right border-bottom border-left">{{ number_format($factura->factura1_bruto,2,',','.') }}&nbsp;</th>
			</tr>
			<tr>
				<th class="right border-bottom border-left">IVA &nbsp;</th>
				<th class="right border-bottom border-left">{{ number_format($factura->factura1_iva,2,',','.') }}&nbsp;</th>
			</tr>
			<tr>
				<th class="right border-bottom border-left">RET/FUENTE&nbsp;</th>
				<th class="right border-bottom border-left"> {{ number_format($factura->factura1_retencion,2,',','.') }}&nbsp;</th>
			</tr>
			<tr>
				<th class="right border-left">TOTAL &nbsp;</th>
				<th class="right border-left">{{ number_format($factura->factura1_total-$factura->factura1_retencion,2,',','.') }}&nbsp;</th>
			</tr>
		</tfoot>
	</table><br>

	<table class="bordered">
		<tr>
			<td colspan="6" rowspan="4">{{$factura->puntoventa_observacion}}</td>
		</tr>
	</table><br>

	<table class="bordered">
		<tr>
			<td width="50%" class="border-right bold padding-text size7">{{$factura->puntoventa_footer1}}</td>
			<td width="50%" valign="top" class="bold padding-text size7">{{$factura->puntoventa_footer2}}</td>
		</tr>
		<tr>
			<td class="border-right"></td>
			<td></td>
		</tr>
		<tr>
			<td class="center border-right">__________________________________________________________</td>
			<td class="center">__________________________________________________________</td>
		</tr>
		<tr>
			<td class="center bold border-right">RECIBÓ A SATISFACCIÓN (FIRMA Y SELLO) FECHA</td>
			<td class="center bold">FIRMA PROVEEDOR</td>
		</tr>
	</table>
@stop
