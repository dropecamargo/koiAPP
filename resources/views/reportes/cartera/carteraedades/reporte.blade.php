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
				<th>LINEA</th>
				<th>Vr/FACT</th>
				<th>Vr/ITEM FACT</th>
				<th>Vr/SUMADO</th>
				<th>Vr/CIERRE</th>
				<th>MORA > 360</th>
				<th>MORA > 180 Y <=360</th>
				<th>MORA > 90 Y <=180</th>
				<th>MORA > 60 Y <=90</th>
				<th>MORA > 30 Y <=60</th>
				<th>MORA > 30 Y <=60</th>
				<th>MORA > 0 Y <=30</th>
				<th>DE 0 A 30</th>
				<th>DE 31 A 60</th>
				<th>DE 61 A 90</th>
				<th>DE 91 A 180</th>
				<th>DE 181 A 360</th>
				<th>> 360</th>
				<th>> 360</th>
				<th>TOTAL MORA</th>
				<th>TOTAL POR VENCER</th>
			</tr>
															


		</thead>
		<tbody>
			{{--@foreach($activoFijo as $item)
				<tr>
					<td>{{ $item->activofijo_placa }}</td>
					<td>{{ $item->activofijo_serie }}</td>
					<td>{{ $item->activofijo_descripcion }}</td>
					<td>{{ number_format($item->activofijo_costo) }}</td>
					<td>{{ number_format($item->activofijo_depreciacion) }}</td>
				</tr>
			@endforeach--}}
		</tbody>
	</table>
@stop