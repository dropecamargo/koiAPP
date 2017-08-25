@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th width="10%">Fecha</th>
				<td colspan="3">{{ $pedidoc->pedidoc1_fecha }}</td>
				<th width="10%">Sucursal</th>
				<td colspan="3">{{ $pedidoc->sucursal_nombre }}</td>
			</tr>
			<tr>
				<th width="10%">Tercero</th>
				<td colspan="7">{{ $pedidoc->tercero_nombre }} - {{ $pedidoc->tercero_nit }}</td>
			</tr>
			<tr>
				<th>Bruto</th>
				<td>{{ number_format($pedidoc->pedidoc1_bruto,2,',','.')  }}</td>
				
				<th>Descuento</th>
				<td>{{ number_format($pedidoc->pedidoc1_descuento,2,',','.')  }}</td>				
				
				<th>Iva</th>
				<td>{{ number_format($pedidoc->pedidoc1_iva,2,',','.')  }}</td>				
				
				<th>Retencion</th>
				<td>{{ number_format($pedidoc->pedidoc1_retencion,2,',','.')  }}</td>				
			</tr>

			<tr>
				<th>Total</th>
				<td>{{ number_format($pedidoc->pedidoc1_total,2,',','.')  }}</td>				

				<th>Cuotas</th>
				<td>{{ $pedidoc->pedidoc1_cuotas }}</td>

				<th>Plazo</th>
				<td>{{ $pedidoc->pedidoc1_plazo }}</td>

				<th>Primer pago</th>
				<td>{{ $pedidoc->pedidoc1_primerpago }}</td>
			</tr>
			<tr>
				<th width="10%">Observaciones</th>
				<td colspan="7">{{ $pedidoc->pedidoc1_observaciones }}</td>
			</tr>
		</tbody>
	</table>
    <br>

    {{-- Detalle pedido comercial --}}
    <table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th width="20%">Referencia</th>
                <th width="30%">Nombre</th>
                <th class="right" width="10%">Cant</th>
                <th class="right" width="10%">Precio</th>
                <th class="right" width="10%">Descuento</th>
                <th class="right" width="10%">Iva</th>
                <th class="right" width="10%">Total</th>
            </tr>
        </thead>
        <tbody>
			{{--*/ $tcant = $tprecio = $tdescuento = $tiva = $total = 0; /*--}}
            @foreach($detalle as $pedidoc2)
	        	{{--*/ 
	        		$subtotal = $pedidoc2->pedidoc2_cantidad * $pedidoc2->pedidoc2_costo;
	        		$subtotal = $subtotal + $pedidoc2->pedidoc2_iva_valor;
	        		$subtotal -=  $pedidoc2->pedidoc2_descuento_valor;
	        	 /*--}}
	            <tr>
	            	<td>{{ $pedidoc2->producto_serie }}</td>
	            	<td>{{ $pedidoc2->producto_nombre }}</td>
	            	<td class="right">{{ $pedidoc2->pedidoc2_cantidad }}</td>
	            	<td class="right">{{ number_format($pedidoc2->pedidoc2_costo,2,',','.') }}</td>
	            	<td class="right">{{ number_format($pedidoc2->pedidoc2_descuento_valor,2,',','.') }}</td>
	            	<td class="right">{{ number_format($pedidoc2->pedidoc2_iva_valor,2,',','.') }}</td>
	            	<td class="right">{{ number_format($subtotal,2,',','.') }}</td>
	            </tr>

	            {{--*/ 
	            	$tcant += $pedidoc2->pedidoc2_cantidad;
	            	$tprecio += $pedidoc2->pedidoc2_costo;
	            	$tdescuento += $pedidoc2->pedidoc2_descuento_valor;
	            	$tiva += $pedidoc2->pedidoc2_iva_valor;
	            	$total += $subtotal;
	            /*--}}
            @endforeach
        </tbody>
        <tfoot>
        	<tr>
            	<th colspan="2" class="right bold">Total: </th>
            	<td class="right bold">{{ $tcant }}</td>
            	<td class="right bold">{{ number_format($tprecio,2,',','.') }}</td>
            	<td class="right bold">{{ number_format($tdescuento ,2,',','.') }}</td>
            	<td class="right bold">{{ number_format($tiva ,2,',','.') }}</td>
            	<td class="right bold">{{ number_format($subtotal ,2,',','.') }}</td>
        	</tr>
        </tfoot>
    </table>
    <div class="center foot">
        <b>Elaboró </b>   {{ $pedidoc->elaboro_nombre }} <br>
    	<b>F. Elaboró </b>   {{ $pedidoc->pedidoc1_fh_elaboro }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop