@extends('reportes.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="20%">DOCUMENTO</th>
				<th width="10%">#</th>
				<th width="50%">SUCURSAL</th>
				<th width="10%">AFEC DOC</th>
				<th width="15%">AFEC #</th>
				<th class="center" width="15%">AFEC CUOTA</th>
				<th width="15%">FECHA E</th>
				<th width="15%">FECHA DOC</th>
				<th width="15%">FECHA PAGO</th>
				<th width="15%">DEBITO</th>
				<th width="15%">CREDITO</th>
			</tr>
		</thead>
		<tbody>
			@if (empty($historyClient))
				<tr class="subtitle">
					<th colspan="11" class="center">NO SE ENCUENTRAN REGISTROS PARA ESTE REPORTE</th>
				</tr>
			@else
				@for($i = 0; $i < count($historyClient); $i++)
					<tr>
						<td>{{ $historyClient[$i]['documento'] }}</td>
						<td>{{ $historyClient[$i]['numero'] }}</td>
						<td>{{ $historyClient[$i]['sucursal'] }}</td>
						<td>{{ $historyClient[$i]['docafecta'] }}</td>
						<td>{{ $historyClient[$i]['id_docafecta'] }}</td>
						<td class="center">{{ $historyClient[$i]['cuota'] }}</td>
						<td>{{ $historyClient[$i]['elaboro_fh'] }}</td>
						<td>{{ $historyClient[$i]['elaboro_fh'] }}</td>
						<td>{{ $historyClient[$i]['elaboro_fh'] }}</td>

						@if ($historyClient[$i]['naturaleza'] == 'C')
							<td>{{ 0 }}</td>
							<td>{{ number_format ($historyClient[$i]['valor']) }}</td>
						@else
							<td>{{ number_format ($historyClient[$i]['valor']) }}</td>
							<td>{{ 0 }}</td>
						@endif
					</tr>
				@endfor
			@endif
		</tbody>
	</table>
@stop