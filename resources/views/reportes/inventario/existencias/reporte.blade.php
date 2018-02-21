@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="10%">REFERENCIA</th>
				<th colspan="{{ $sucursales->count() }}">NOMBRE PRODUCTO</th>
				<th colspan="3">LINEA</th>
			</tr>

			<tr>
				<th></th>
				<th width="5%" class="center">COSTO</th>
				@for($i = 1; $i <= $sucursales->count() ; $i++)
					<th width="5%" class="center">BOD{{ $i }}</th>
				@endfor
				<th width="5%" class="center">TOTAL</th>
				<th width="5%" class="center">PRECIO VENTA</th>
			</tr>
		</thead>
		<tbody>
			@if($prodbode->isEmpty())
				<tr class="subtitle">
					<th colspan="{{$sucursales->count() + 4 }}" class="center">NO SE ENCUENTRAN REGISTROS PARA ESTE REPORTE</th>
				</tr>
			@endif
			{{--*/ $auxSerie = '' ; $tCantidad = 0; /*--}}
			@foreach($prodbode as $item)
				@if($auxSerie != $item->producto_serie)
					<tr class="brtable">
						<th class="size-6 ">{{$item->producto_serie}}</th>
						<th class="size-6" colspan="{{ $sucursales->count() }}">{{$item->producto_nombre}}</th>
						<th class="size-6" colspan="3">{{$item->linea_nombre}}</th>
					</tr>
					<tr class="brtable">
						<td></td>
						<td class="center size-6">{{number_format($item->producto_costo,2, ',', '.')}}</td>
						{{--*/ $tCantidad = 0; /*--}}
						@foreach( $sucursales as $sucursal )
								{{--*/ $exist =  App\Models\Inventario\Prodbode::reportExist($sucursal->id, $item->id_producto) /*--}}
								@if( !$exist->isEmpty() )
									{{--*/ $cant =  $exist[0]->metros > 0 ? $exist[0]->metros : $exist[0]->cantidad ; $tCantidad += $cant; /*--}}
									<td class="center size-6">{{ $cant }}</td>
								@else
									<td class="center size-6">0</td>
								@endif
						@endforeach
						<td class="center">{{ $tCantidad }}</td>
						<td class="center">{{ number_format($item->venta,2, ',' , '.') }}</td>
					</tr>
					{{--*/ $auxSerie = $item->producto_serie;/*--}}
				@endif
			@endforeach
		</tbody>
	</table>
	<div class="center foot">
		<b>Usuario </b>  {{ $user }} <br>
		<b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
	</div>
@stop
