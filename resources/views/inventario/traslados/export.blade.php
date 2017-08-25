@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="15%">Fecha</th>
				<td colspan="3">{{ $traslado->traslado1_fecha }}</td>
			</tr>
			<tr>
				<th width="10%">Origen</th>
				<td width="10%">{{ $traslado->origen }}</td>

				<th width="10%">Destino</th>
				<td width="70%">{{ $traslado->destino }}</td>
			</tr>
			<tr>
				<th width="15%">Tipo</th>
				<td width="15%">{{ $traslado->tipotraslado_nombre }}</td>
			</tr>

			<tr>
				<th width="20%">Detalle</th>
				<td width="80%">{{ $traslado->traslado1_observaciones }}</td>
			</tr>
		</tbody>
	</table>
    <br>
    {{-- Detalle traslado --}}
    <table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th width="30%">Referencia</th>
                <th width="50%">Nombre</th>
                <th width="10%">Cantidad</th>
                <th class="right" width="10%">Costo</th>
            </tr>
        </thead>
        <tbody>
			{{--*/ $total = 0; /*--}}
            @foreach($detalle as $traslado2)
            <tr>
            	<td>{{ $traslado2->producto_serie }}</td>
            	<td>{{ $traslado2->producto_nombre }}</td>
            	<td>{{ $traslado2->traslado2_cantidad }}</td>
            	<td class="right">{{ number_format($traslado2->traslado2_costo,2,',','.')}}</td>
            </tr>

			{{-- Calculo totales --}}
			{{--*/
				$total += $traslado2->traslado2_costo;
			/*--}}
            @endforeach
        </tbody>

       	<tfoot>
			<tr>
				<td colspan="3" class="right bold">TOTAL</td>
				<td class="right bold">{{ number_format($total,2,'.',',') }}</td>
			</tr>
       	</tfoot>
    </table>
    <div class="center foot">
        <b>Elaboró </b>   {{ $traslado->username_elaboro }} <br>
    	<b>F. Elaboró </b>   {{ $traslado->traslado1_fh_elaboro }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop