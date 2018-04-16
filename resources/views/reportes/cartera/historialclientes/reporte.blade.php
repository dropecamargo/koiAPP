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
				<th width="15%">FECHA DOC</th>
				<th width="15%">FECHA E</th>
				<th width="15%">DEBITO</th>
				<th width="15%">CREDITO</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $tdebito = $tcredito = 0; /*--}}
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
						<td>{{ $historyClient[$i]['fecha'] }}</td>
						<td>{{ $historyClient[$i]['elaboro_fh'] }}</td>

						@if ($historyClient[$i]['naturaleza'] == 'C')
							<td class="right">{{ 0 }}</td>
							{{--*/ ($historyClient[$i]['afectaCode'] != 'CHP') ? $tcredito += $historyClient[$i]['valor']: ''; /*--}}
							<td class="right">{{ number_format ($historyClient[$i]['valor'],2,'.',',') }}</td>
						@else
							{{--*/ ($historyClient[$i]['afectaCode'] != 'CHP') ? $tdebito += $historyClient[$i]['valor']: '' ; /*--}}
							<td class="right">{{ number_format ($historyClient[$i]['valor'],2,'.',',') }}</td>
							<td class="right">{{ 0 }}</td>
						@endif
					</tr>
				@endfor
			@endif
		</tbody>
		<tfoot>
			<tr>
				<th colspan="8" class="right">Total(es)</th>
				<th class="right">{{ number_format($tdebito,2,'.',',') }}</th>
				<th class="right">{{ number_format($tcredito,2,'.',',') }}</th>
			</tr>
		</tfoot>
	</table>
@stop
