@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			{{--<tr>
				<th width="5%">REFERENCIA</th>
				<th width="5%">NOMBRE</th>
			</tr>--}}

			<tr>
				<th width="10%" class="left">DOCUMENTO</th>
				<th width="10%" class="left">SUCURSAL</th>
				<th width="5%" class="left">NÚMERO</th>
				<th width="10%" class="left">FECHA</th>
				<th width="10%" class="left">HORA</th>
				<th width="10%" class="left">USUARIO</th>
				<th width="5%" class="left">ENTRADA</th>
				<th width="5%" class="left">SALIDA</th>
				<th width="10%" class="left">COSTO</th>
				<th width="10%" class="left">COSTO PROMEDIO</th>
			</tr>
		</thead>
		<tbody>
			@foreach($inventario as $item)
				<tr>
					<td class="left">{{ $item->documentos_nombre }}</td>
					<td class="left">{{ $item->sucursal_nombre }}</td>
					<td class="left">{{ $item->inventario_id_documento }}</td>
					<td class="left">{{ $item->inventario_fecha }}</td>
					<td class="left">{{ $item->inventario_hora }}</td>
					<td class="left">{{ $item->username }}</td>
					<td class="left">{{ $item->inventario_entrada > 0 ? $item->inventario_entrada : $item->inventario_metros_entrada }}</td>
					<td class="left">{{ $item->inventario_salida > 0 ? $item->inventario_salida : $item->inventario_metros_salida }}</td>
					<td class="left">{{ number_format($item->inventario_costo) }}</td>
					<td class="left">{{ number_format($item->inventario_costo_promedio) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop