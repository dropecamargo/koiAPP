@extends('reportes.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="10%">Sucursal</th>
				<td width="30%">{{ $orden->sucursal_nombre }}</td>
				<th width="10%">Fecha servicio</th>
				<td width="10%">{{ $orden->orden_fecha_servicio }}</td>
				<th width="10%">Hora servcio</th>
				<td width="10%">{{ $orden->orden_hora_servicio }}</td>
			</tr>
			<tr>
				<th width="10%">Tercero</th>
				<td colspan="5">{{ $orden->tercero_nombre }} - {{ $orden->tercero_nit }}</td>
			</tr>
			<tr>
				<th width="10%">Contacto</th>
				<td colspan="1">{{ $orden->tcontacto_nombre }}</td>
				<th width="10%">Teléfono</th>
				<td colspan="1">{{ $orden->tcontacto_telefono }}</td>
				<th width="10%">Correo</th>
				<td colspan="1">{{ $orden->tcontacto_email }}</td>
			</tr>
			<tr>
				<th>Producto</th>
				<td colspan="1">{{ $orden->producto_serie }}</td>
				<td colspan="4"> {{ $orden->producto_nombre }}</td>
			</tr>
			<tr>
				<th width="10%">Tecnico</th>
				<td colspan="5">{{ $orden->tecnico_nombre }} - {{ $orden->tecnico_nit }}</td>
			</tr>
			<tr>
				<th>Daño</th>
				<td colspan="1">{{ $orden->dano_nombre }}</td>
				<th>Solicitante</th>
				<td colspan="3">{{ $orden->solicitante_nombre }}</td>
			</tr>
			<tr>
				<th>Sitio</th>
				<td colspan="1">{{ $orden->sitio_nombre }}</td>
				<th>Prioridad</th>
				<td colspan="3">{{ $orden->prioridad_nombre }}</td>
			</tr>
			<tr>
				<th>Tipo orden</th>
				<td colspan="1">{{ $orden->tipoorden_nombre }}</td>
				<th>Problema</th>
				<td colspan="3">{{ $orden->orden_problema }}</td>
			</tr>
			<tr>
				<th width="10%">Persona</th>
				<td colspan="3">{{ $orden->orden_llamo }}</td>
				<th width="10%">Estado</th>
				<td colspan="1">{{ ($orden->orden_abierta ) ? 'ABIERTA' : 'CERRADA' }}</td>
			</tr>
		</tbody>
	</table>
    <br>
	@if (count($visita) > 0)
		<table class="tbtitle">
			<thead>
				<tr><td class="titleespecial">Visitas</td></tr>
			</thead>
		</table>

		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	        <thead>
		        <tr>
		            <th width="5%">#</th>
		            <th width="10%">Llegada</th>
		            <th width="10%">Inicio</th>
		            <th width="20%">Tecnico</th>
		            <th width="10%">Transporte (hrs)</th>
		            <th width="10%">Viaticos</th>
		            <th width="30%">Observacines</th>
		        </tr>
	       	<thead>
	       	<tbody>
				@foreach ($visita as $item)
					<tr>
						<td>{{ $item->visita_numero }}</td>
						<td>{{ $item->visita_fh_llegada }}</td>
						<td>{{ $item->visita_fh_inicio }}</td>
						<td>{{ $item->tercero_nombre }}</td>
						<td class="center">{{ $item->visita_tiempo_transporte }}</td>
						<td>{{ number_format($item->visita_viaticos ,2,',','.') }}</td>
						<td>{{ $item->visita_observaciones }}</td>
					</tr>
				@endforeach
	       	</tbody>
		</table>
		<br>
	@endif

	@if (count($remision) > 0)
		<table class="tbtitle">
			<thead>
				<tr><td class="titleespecial">Remisiones/Legalizaciones</td></tr>
			</thead>
		</table>
		@foreach ($remision as $item)
			<table class="htable" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th width="15%">Tipo</th>
					<td width="15%"> {{ ($item->remrepu1_tipo == 'R') ? 'REMISIÓN' : 'LEGALIZACIÓN'}}</td>
					<th width="15%">Número</th>
					<td width="15%">{{ $item->remrepu1_numero }}</td>
				</tr>
				<tr>
					<th>Sucursal</th>
					<td>{{ $item->sucursal_nombre}}</td>
					<th>Tecnico</th>
					<td>{{ $item->tecnico_nombre}}</td>
				</tr>
			</table>
			<table class="tbtitle">
				<thead>
					<tr><td class="subtitleespecial">Detalle {{ ($item->remrepu1_tipo == 'R') ? 'REMISIÓN # ' : 'LEGALIZACIÓN #' }} {{ $item->remrepu1_numero }}</td></tr>
				</thead>
			</table>
			<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		        <thead>
		            <tr>
		                <th width="20%">Referencia</th>
		                <th width="40%">Nombre</th>
		                @if ($item->remrepu1_tipo == 'R')
		                	<th width="10%">Cantidad</th>
		                @else
		                	<th class="center" width="10%">Facturado</th>
		                	<th class="center" width="10%">No facturado</th>
		                	<th class="center" width="10%">Devuelto</th>
		                	<th class="center" width="10%">Usado</th>
		                @endif
		            </tr>
    			</thead>
    			<tbody>
					<tr>
						<td>{{ $item->producto_serie }}</td>
						<td>{{ $item->producto_nombre }}</td>

						@if ($item->remrepu1_tipo == 'R')
							<td>{{ $item->remrepu2_cantidad }}</td>
						@else
							<td class="center">{{ $item->remrepu2_facturado }}</td>
							<td class="center">{{ $item->remrepu2_no_facturado }}</td>
							<td class="center">{{ $item->remrepu2_devuelto }}</td>
							<td class="center">{{ $item->remrepu2_usado }}</td>
						@endif
					</tr>
    			</tbody>
    			<tfoot class="separator"></tfoot><br>
			</table>
		@endforeach
	@endif
@stop