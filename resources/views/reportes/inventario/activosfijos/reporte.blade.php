@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%">PLACA</th>
				<th width="15%">SERIE</th>
				<th width="50%">DESCRIPCIÓN</th>
				<th width="10%">COSTO</th>
				<th width="10%">DEPRECIACION</th>
			</tr>
		</thead>
		<tbody>
			@foreach($activoFijo as $item)
				<tr>
					<td>{{ $item->activofijo_placa }}</td>
					<td>{{ $item->activofijo_serie }}</td>
					<td>{{ $item->activofijo_descripcion }}</td>
					<td>{{ number_format($item->activofijo_costo) }}</td>
					<td>{{ number_format($item->activofijo_depreciacion) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop