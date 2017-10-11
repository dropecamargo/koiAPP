@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="1" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="10%">REFERENCIA</th>
				<th colspan="{{ $producto['numSucursal']}}">NOMBRE PRODUCTO</th>
				<th colspan="3">SUBCATEGORIA</th>
			</tr>

			<tr>
				<th></th>
				<th width="5%" class="center">COSTO</th>
				@for($i = 1; $i <= $producto['numSucursal'] ; $i++) 
					<th width="5%" class="center">BOD{{ $i }}</th>
				@endfor
				<th width="5%" class="center">TOTAL</th>
				<th width="5%" class="center">PRECIO VENTA</th>
			</tr>
		</thead>
		<tbody class="subtitle">
			@if($producto['query']->isEmpty())
				<tr class="subtitle">
					<th colspan="{{$producto['numSucursal'] + 4 }}" class="center">NO SE ENCUENTRAN REGISTROS PARA ESTE REPORTE</th>
				</tr>
			@endif
			@foreach($producto['query'] as $item)
				<tr>
					<th class="left">{{ $item->serie }}</th>
					<th class="left" colspan="{{ $producto['numSucursal'] }}">{{ $item->nombre }}</th>
					<th class="left" colspan="3">{{ $item->subcategoria }}</th>
				</tr>
				<tr>
					<td></td>
					<td class="center">{{ number_format($item->costo) }}</td>

					@for($i = 1; $i <= $producto['numSucursal'] ; $i++)
						{{--*/ $unidad = 'unidad'.$i /*--}} 
						<td width="5%" class="center">{{ $item->$unidad }}</td>
					@endfor

					<td width="5%" class="center">{{ number_format($item->precio) }}</td>
					<td class="center">{{ number_format($item->precio) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop