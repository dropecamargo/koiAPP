@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="10%">Fecha</th>
				<td width="15%">{{ $egreso->egreso1_fecha }}</td>
				<th width="10%">Regional</th>
				<td width="15%">{{ $egreso->regional_nombre }}</td>
				<th width="10%">Estado</th>
				<td width="15%">{{ ( !$egreso->egreso1_anulado ) ? 'ACTIVO' : 'ANULADO' }}</td>
			</tr>
			<tr>
				<th width="15%">Tercero</th>
				<td colspan="5">{{ $egreso->tercero_nombre }}</td>
			</tr>
			<tr>
				<th width="15%">Cuenta</th>
				<td colspan="5">{{ $egreso->cuentabanco_nombre }}</td>
			</tr>
			<tr>
				<th width="15%">N° cheque</th>
				<td colspan="1">{{ $egreso->egreso1_numero_cheque }}</td>

				<th width="15%">Fecha cheque</th>
				<td colspan="1">{{ $egreso->egreso1_fecha_cheque }}</td>

				<th width="15%">Velor cheque</th>
				<td colspan="1">{{ number_format($egreso->egreso1_valor_cheque ,2,',','.') }}</td>
			</tr>
			<tr>
				<th width="15%">Observaciones</th>
				<td colspan="4">{{ $egreso->egreso1_observaciones }}</td>
			</tr>
		</tbody>
	</table>
    <br>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
	        <tr>
	            <th>Tercero</th>
	            <th>Tipo</th>
	            <th>Valor</th>
	        </tr>
       	<thead>
       	<tbody>
			@foreach ( $detalle as $item)
				<tr>
					<td>{{ $item->tercero2_nombre }}</td>
					<td>{{ $item->tipopago_nombre }}</td>
					<td>{{ number_format($item->egreso2_valor ,2,',','.') }}</td>
				</tr>
			@endforeach
       	</tbody>
	</table>

    <div class="center foot">
        <b>Elaboró </b>   {{ $egreso->elaboro_nombre }} <br>
    	<b>F. Elaboró </b>   {{ $egreso->egreso1_fh_elaboro }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop