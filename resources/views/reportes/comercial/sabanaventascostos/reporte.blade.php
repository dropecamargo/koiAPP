@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%">LINEA</th>
				@foreach ($regionales as $regional)
					<th>{{ $regional->regional_nombre }}</th>
				@endforeach
				<th width="15%">TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@if($sabanaVentas->isEmpty())
				<tr class="subtitle">
					<th colspan="5" class="center">NO SE ENCUENTRAN REGISTROS PARA ESTE REPORTE</th>
				</tr>
			@endif
			<tr><td colspan="{{ $regionales->count() + 2 }}"></td></tr>
			{{--*/ $auxSubCategoria = 0; /*--}}	
			@foreach($sabanaVentas as $item)
				{{--*/ $totalLineV = $totalLineD  = $totalLineDev = $lineTotal = $totalLinePresu = $linePorcentaje = 0; /*--}}	
				
				<tr>
					<td colspan="{{ $regionales->count() + 2 }}" class="bold">{{ $item->auxreporte_varchar1 }}</td>
				</tr>

				<tr>
					<td colspan="{{ $regionales->count() + 2 }}" class="bold">{{ $item->auxreporte_varchar2 }}</td>
				</tr>

				<tr>
					<td colspan="{{ $regionales->count() + 2 }}" class="bold">{{ $item->auxreporte_varchar3 }}</td>
				</tr> 

				@if ($item->auxreporte_integer4 != $auxSubCategoria)
					<tr>
						<td colspan="{{ $regionales->count() + 2 }}" class="bold">{{ $item->auxreporte_varchar4 }}</td>
					</tr>
					<tr>
						<td class="center">VENTAS</td>
						@foreach ($regionales as $key => $regional)
							{{--*/ $referenceVenta = $regional->id."V"; $totalLineV += $item->$referenceVenta/*--}}
							<td>{{ number_format($item->$referenceVenta,2,'.',',') }}</td>
						@endforeach
						<td>{{ number_format($totalLineV,2,'.',',') }}</td>
					</tr>
					<tr>
						<td class="center">DESCUENTOS</td>
						@foreach ($regionales as $key => $regional)
							{{--*/$referenceDescuento = $regional->id."D"; $totalLineD += $item->$referenceDescuento/*--}}
							<td>{{ number_format($item->$referenceDescuento,2,'.',',') }}</td>
						@endforeach
						<td>{{ number_format($totalLineD,2,'.',',') }}</td>
					</tr>
					<tr>
						<td class="center">DEVOLUCIONES</td>
						@foreach ($regionales as $key => $regional)
							{{--*/$referenceDevolucion = $regional->id."d"; $totalLineDev += $item->$referenceDevolucion/*--}}
							<td>{{ number_format($item->$referenceDevolucion,2,'.',',') }}</td>
						@endforeach
						<td>{{ number_format($totalLineDev,2,'.',',') }}</td>
					</tr>
					<tr>
						<td class="center">TOTAL</td>
						@foreach ($regionales as $key => $regional)
							{{--*/ $referenceVenta = $regional->id."V"; $referenceDescuento = $regional->id."D"; $referenceDevolucion = $regional->id."d"/*--}}
							{{--*/ $data = $item->$referenceVenta - ($item->$referenceDescuento + $item->$referenceDevolucion); $lineTotal += $data; /*--}}
							<td>{{ number_format($data,2,'.',',') }}</td>
						@endforeach
						<td>{{ number_format($lineTotal,2,'.',',') }}</td>
					</tr>
					<tr>
						<td class="center">PRESUPUESTO</td>
						@foreach ($regionales as $key => $regional)
							{{--*/$referencePresupuesto = "$regional->id-$auxSubCategoria";  (isset($presupuesto[$referencePresupuesto])) ? $totalLinePresu += $presupuesto[$referencePresupuesto] : '' /*--}}
							<td>{{(isset($presupuesto[$referencePresupuesto])) ? number_format($presupuesto[$referencePresupuesto],2,'.',',') : number_format(0,2,'.',',') }}</td>
						@endforeach
						<td>{{ number_format($totalLinePresu,2,'.',',') }}</td>
					</tr>
					<tr>
						<td class="center">PORCENTAJE</td>
						@foreach ($regionales as $key => $regional)
							{{--*/  
								$referenceVenta = $regional->id."V"; $referenceDescuento = $regional->id."D"; 
								$referenceDevolucion = $regional->id."d"; 
					 			$referencePresupuesto = "$regional->id-$auxSubCategoria"; 
				 			/*--}}

							@if (isset($presupuesto[$referencePresupuesto]) && $presupuesto[$referencePresupuesto] != 0)
								{{--*/ 
									$factor = 100/$presupuesto[$referencePresupuesto];
									$data = ($item->$referenceVenta - ( $item->$referenceDescuento + $item->$referenceDevolucion )) * $factor; 
								/*--}}
							@else
								{{--*/ $data = 0; /*--}}
							@endif

							<td>{{ number_format($data,2,'.',',') }}</td>
						@endforeach
						<td>{{ number_format($linePorcentaje,2,'.',',') }}</td>
					</tr>
					<tr>
						<td class="center">COSTOS</td>
					</tr>
				@endif
				{{--*/ $auxSubCategoria = $item->auxreporte_integer4;  /*--}}	
				<tr><td colspan="{{ $regionales->count() + 2 }}"></td></tr>
				<tr><td colspan="{{ $regionales->count() + 2 }}"></td></tr>
			@endforeach
		</tbody>
	</table>
@stop
