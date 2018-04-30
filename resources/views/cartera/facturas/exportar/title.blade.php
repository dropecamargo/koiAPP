<table class="tbtitle">
	<thead>
		<tr>
			<td rowspan="4" class="center"><img src="{{ asset(config('koi.logo')) }}" alt="{{ config('koi.name') }}" width="100px"></td>
			<td colspan="3"class="company">{{ $empresa->tercero_razonsocial }}</td>
		</tr>
		<tr>
			<td colspan="3" class="nit">NIT: {{ $empresa->tercero_nit }}</td>
		</tr>
		<tr>
			<td></td>
			<td class="regimen">{{ config('koi.regimen') }}</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="3"class="nit">{{ config('koi.detalle') }}</td>
		</tr>
	</thead>
</table>
