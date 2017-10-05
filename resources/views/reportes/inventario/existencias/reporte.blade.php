@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="1" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="5%">REFERENCIA</th>
				<th colspan="{{ $producto['numSucursal'] + 3}}">NOMBRE PRODUCTO</th>
			</tr>

			<tr>
				<th></th>
				<th width="5%" class="center">COSTO</th>
				@for($i = 1; $i <= $producto['numSucursal'] ; $i++) 
					<th width="5%" class="center">BOD{{ $i }}</th>
				@endfor
				<th width="10%" class="center">TOTAL</th>
				<th width="15%" class="center">PRECIO VENTA</th>
			</tr>
		</thead>
		<tbody>
			@foreach($producto['query'] as $item)
				<tr>
					<td class="left">{{ $item->producto_serie }}</td>
					<td class="left" colspan="{{ $producto['numSucursal'] + 3 }}">{{ $item->producto_nombre }}</td>
				</tr>
				<tr>
					<td></td>
					<td class="center">{{ number_format($item->producto_costo) }}</td>
					@for($i = 1; $i <= $producto['numSucursal'] ; $i++) 
						<td width="5%" class="center"></td>
					@endfor
					<td class="center">{{ number_format($item->producto_co) }}</td>
					<td class="center">{{ $item->producto_precio1 }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop