@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="1" cellspacing="0" cellpadding="0">
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
		{{--<tbody>
			@foreach($invetario as $item)
				<tr>
					<td class="left">{{ $item->documento_nombre }}</td>
					<td class="left">{{ $item->sucursal_nombre }}</td>
					<td class="center">{{ $item->producto_nivel }}</td>
					<td class="center">{{ $item->producto_naturaleza }}</td>
					<td class="right">{{ $item->producto_tasa }}</td>
					<td class="left">{{ number_format($item->producto_costo) }}</td>
				</tr>
			@endforeach
		</tbody>--}}
	</table>
@stop