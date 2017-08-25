@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="15%">Fecha</th>
				<td width="15%">{{ $trasladou->trasladou1_fecha }}</td>
				<th width="15%">Sucursal</th>
				<td width="15%">{{ $trasladou->sucursal_nombre }}</td>
			</tr>
			<tr>
				<th width="10%">Origen</th>
				<td width="10%">{{ $trasladou->origen }}</td>

				<th width="10%">Destino</th>
				<td width="70%">{{ $trasladou->destino }}</td>
			</tr>
			<tr>
				<th width="15%">Tipo</th>
				<td width="15%">{{ $trasladou->tipotraslado_nombre }}</td>
			</tr>

			<tr>
				<th width="20%">Detalle</th>
				<td width="80%">{{ $trasladou->trasladou1_observaciones }}</td>
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
            </tr>
        </thead>
        <tbody>
            @foreach($detalle as $trasladou2)
	            <tr>
	            	<td>{{ $trasladou2->producto_serie }}</td>
	            	<td>{{ $trasladou2->producto_nombre }}</td>
	            	<td>{{ $trasladou2->trasladou2_cantidad }}</td>
	            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="center foot">
        <b>Elaboró </b>   {{ $trasladou->username_elaboro }} <br>
    	<b>F. Elaboró </b>   {{ $trasladou->trasladou1_fh_elaboro }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop