@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="15%">Fecha</th>
				<td width="10%">{{ $ajuste->ajuste1_fecha }}</td>
			</tr>
			<tr>
				<th width="15%">Sucursal</th>
				<td width="15%">{{ $ajuste->sucursal_nombre }}</td>

				<th class="center" width="45%">Número</th>
				<td class="left" width="15%">{{ $ajuste->ajuste1_numero }}</td>
			</tr>
			<tr>
				<th width="15%">Tipo</th>
				<td width="15%">{{ $ajuste->documentos_nombre }} - {{ $ajuste->tipoajuste_nombre }}</td>
			</tr>

			<tr>
				<th width="20%">Observaciones</th>
				<td width="80%">{{ $ajuste->ajuste1_observaciones }}</td>
			</tr>
		</tbody>
	</table>
    <br>
    {{-- Detalle ajuste --}}
    <table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th width="20%">Referencia</th>
                <th width="50%">Nombre</th>
                <th width="10%">Entrada</th>
                <th width="10%">Salida</th>
                <th width="10%">Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalle as $ajuste2)
            <tr>
            	<td>{{ $ajuste2->producto_serie }}</td>
            	<td>{{ $ajuste2->producto_nombre }}</td>
            	<td>{{ $ajuste2->ajuste2_cantidad_entrada }}</td>
            	<td>{{ $ajuste2->ajuste2_cantidad_salida }}</td>
            	<td>{{ number_format($ajuste2->ajuste2_costo,2,',','.')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="center foot">
        <b>Elaboró </b>   {{ $ajuste->tercero_nombre }} - {{ $ajuste->tercero_nit}} <br>
    	<b>F. Elaboró </b>   {{ $ajuste->ajuste1_fh_elaboro }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop