@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="1" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>DOCUMENTO</th>
				<th>SUCURSAL</th>
				<th>#</th>
				<th>CUOTA</th>
				<th>CLIENTE</th>
				<th>VENDEDOR</th>
				<th>VALOR</th>
				<th>SALDO</th>
				<th>MORA > 360</th>
				<th>MORA > 180 Y <=360</th>
				<th>MORA > 90 Y <=180</th>
				<th>MORA > 60 Y <=90</th>
				<th>MORA > 30 Y <=60</th>
				<th>MORA > 0 Y <=30</th>
				<th>DE 0 A 30</th>
				<th>DE 31 A 60</th>
				<th>DE 61 A 90</th>
				<th>DE 91 A 180</th>
				<th>DE 181 A 360</th>
				<th>> 360</th>
				<th>TOTAL MORA</th>
				<th>TOTAL POR VENCER</th>
			</tr>
															


		</thead>
		<tbody>
			@foreach($carteraEdades as $item)
				{{--*/ $totalMora = $item->valor_m360 + $item->valor_m180 + $item->valor_m90 + $item->valor_m60 + $item->valor_m30 + $item->valor_m0; /*--}}
				{{--*/ $totalPorVencer = $item->valor_pv_m0 + $item->valor_pv_m30 + $item->valor_pv_m60 + $item->valor_pv_m90 + $item->valor_pv_m180 + $item->valor_pv_m360; /*--}}
				<tr>
					<td>{{ $item->documento }}</td>
					<td>{{ $item->sucursal }}</td>
					<td>{{ $item->numero }}</td>
					<td>{{ $item->cuota }}</td>
					<td>{{ $item->tercero_nit }} - {{ $item->tercero_nombre }}</td>
					<td>{{ $item->vendedor_nit }} - {{ $item->vendedor_nombre }}</td>
					<td>{{ number_format($item->valor) }}</td>
					<td>{{ number_format($item->saldo) }}</td>
					<td>{{ number_format($item->valor_m360) }}</td>
					<td>{{ number_format($item->valor_m180) }}</td>
					<td>{{ number_format($item->valor_m90) }}</td>
					<td>{{ number_format($item->valor_m60) }}</td>
					<td>{{ number_format($item->valor_m30) }}</td>
					<td>{{ number_format($item->valor_m0) }}</td>
					<td>{{ number_format($item->valor_pv_m0) }}</td>
					<td>{{ number_format($item->valor_pv_m30) }}</td>
					<td>{{ number_format($item->valor_pv_m60) }}</td>
					<td>{{ number_format($item->valor_pv_m90) }}</td>
					<td>{{ number_format($item->valor_pv_m180) }}</td>
					<td>{{ number_format($item->valor_pv_m360) }}</td>
					<td>{{ number_format($totalMora) }}</td>
					<td>{{ number_format($totalPorVencer) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop