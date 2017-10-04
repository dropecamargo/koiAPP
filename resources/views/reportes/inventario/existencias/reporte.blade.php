@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="5%">REFERENCIA</th>
				<th colspan="{{ $producto['numSucursal']}}">NOMBRE PRODUCTO</th>
			</tr>

			<tr>
				<th></th>
				<th width="5%" class="center">COSTO</th>
				@for($i = 1; $i <= $producto['numSucursal'] ; $i++) 
					<th width="5%" class="center">BOD{{ $i }}</th>
				@endfor
				<th width="5%" class="center">NV</th>
				<th width="5%" class="center">C/D</th>
				<th width="5%" class="center">TER</th>
				<th width="8%" class="center">TASA</th>
			</tr>
		</thead>
		<tbody>
			@foreach($producto['query'] as $item)
				<tr>
					<td class="left">{{ $item->producto_serie }}</td>
					<td class="left" colspan="{{ $producto['numSucursal']}}">{{ $item->producto_nombre }}</td>
				</tr>
				<tr>
					<td></td>
					<td class="left">{{ number_format($item->producto_costo) }}</td>
					<td class="left">{{ $item->producto_nom }}</td>
					<td class="center">{{ $item->producto_nivel }}</td>
					<td class="center">{{ $item->producto_naturaleza }}</td>
					<td class="right">{{ $item->producto_tasa }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop