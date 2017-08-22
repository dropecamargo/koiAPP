@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="10%">Regional</th>
				<td width="15%">{{ $ajustep->regional_nombre }}</td>
				<th width="10%">Número</th>
				<td width="15%">{{ $ajustep->ajustep1_numero }}</td>
			</tr>
			<tr>
				<th width="15%">Tercero</th>
				<td colspan="5">{{ $ajustep->tercero_nombre }}</td>
			</tr>
			<tr>
				<th width="15%">Concepto</th>
				<td colspan="5">{{ $ajustep->conceptoajustep_nombre }}</td>
			</tr>
			<tr>
				<th width="15%">Observaciones</th>
				<td colspan="5">{{ $ajustep->ajustep1_observaciones }}</td>
			</tr>
		</tbody>
	</table>
    <br>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
	        <tr>
	            <th>Tercero</th>
	            <th>Documento</th>
	            <th>Número</th>
	            <th>Cuota</th>
	            <th>Credito</th>
	            <th>Debito</th>
	        </tr>
       	<thead>
       	<tbody>
			{{--*/ $tdebito = $tcredito = 0; /*--}}
			@foreach ( $detalle as $item)
				<tr>
					<td>{{ $item->tercero_nombre }}</td>
					<td>{{ $item->documentos_nombre }}</td>
					<td>{{ $item->facturap1_numero }}</td>
					<td>{{ $item->facturap3_cuota }}</td>
					<td class="right">{{ ($item->ajustep2_naturaleza == 'C') ? number_format($item->ajustep2_valor ,2,',','.') : 0 }}</td>
					<td class="right">{{ ($item->ajustep2_naturaleza == 'D') ? number_format($item->ajustep2_valor ,2,',','.') : 0 }}</td>
				</tr>
				{{-- Calculo totales --}}
				{{--*/
					$tcredito += ($item->ajustep2_naturaleza == 'C') ? $item->ajustep2_valor : 0;
					$tdebito += ($item->ajustep2_naturaleza == 'D') ? $item->ajustep2_valor : 0;
				/*--}}
			@endforeach
       	</tbody>
       	<tfoot>
			<tr>
				<td colspan="4" class="right bold">TOTAL</td>
				<td class="right bold">{{ number_format($tcredito,2,'.',',') }}</td>
				<td class="right bold">{{ number_format($tdebito,2,'.',',') }}</td>
			</tr>
       	</tfoot>
	</table>

    <div class="center foot">
        <b>Elaboró </b>   {{ $ajustep->elaboro_nombre }} <br>
    	<b>F. Elaboró </b>   {{ $ajustep->ajustep1_fh_elaboro }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop