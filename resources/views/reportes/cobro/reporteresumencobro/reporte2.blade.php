@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th colspan="13" align="center">Fecha inicio: {{ $fecha_inicio }}  Fecha final: {{ $fecha_final }} </th>
			</tr>

			<tr>
				<th align="left">Nit</th>
				<th align="left">Nombre Tercero</th>
				<th align="left">Fecha</th>
				<th align="center">Hora</th>
				<th align="center">Nombre Concepto</th>
				<th align="left">Proxima Llamada</th>
				<th align="left">Deudor nit</th>
				<th align="center">Deudor</th>
			</tr>
		</thead>
		<tbody>
			@foreach($llamadas_p as $item)
				<tr>
					<td align="left">{{  $item->tercero_nit }}</td>
					<td align="rigth">{{ $item->tercero_nombre }}</td>
					<td align="left">{{  $item->gestiondeudor_fecha }}</td>
					<td align="rigth">{{ $item->gestiondeudor_hora }}</td>
					<td align="rigth">{{ $item->conceptocob_nombre }}</td>
					<td align="rigth">{{ $item->gestiondeudor_proxima }}</td>
					<td align="rigth">{{ $item->deudor_nit }}</td>
					<td align="rigth">{{ $item->deudor_nombre }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
