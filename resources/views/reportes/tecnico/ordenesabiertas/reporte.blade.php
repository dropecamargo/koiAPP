@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="10%">No.</th>
				<th width="15%">DOCUMENTO</th>
				<th width="30%">NOMBRE</th>
				<th width="15%">SERIE</th>
				<th width="30%">PRODUCTO</th>
			</tr>
		</thead>
		<tbody>
			@if($ordenes->isEmpty())
				<tr class="subtitle">
					<th colspan="5" class="center">NO SE ENCUENTRAN REGISTROS PARA ESTE REPORTE</th>
				</tr>
			@endif
			{{--*/ $auxSucursal = null; /*--}}
			@foreach($ordenes as $item)
				@if ($auxSucursal != $item->sucursal_id)
					<tr class="brtable">
						<th colspan="5" class="subtitleespecial">{{$item->sucursal_nombre}}</th>
					</tr>
				@endif
				<tr>
					<td>{{ $item->orden_numero }}</td>
					<td>{{ $item->tercero_nit }}</td>
					<td>{{ $item->tercero_nombre }}</td>
					<td>{{ $item->producto_serie }}</td>
					<td>{{ $item->producto_nombre }}</td>
				</tr>
				{{--*/ $auxSucursal = $item->sucursal_id; /*--}}
			@endforeach
		</tbody>
	</table>
@stop