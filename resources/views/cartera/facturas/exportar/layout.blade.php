<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{{ $title }}</title>
		{{-- Include css pdf --}}
		@if($type == 'pdf')
			<style type="text/css">
				body {
					font-size: 7;
					font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
					font-weight: normal;
				}
				@page{
					margin-top: 35px;
					margin-bottom: 35px;
				}
				.company{
					font-size: 12;
					font-weight: bold;
					text-align: center;
				}

				.nit{
					font-size: 10;
					font-weight: bold;
					text-align: center;
				}

				.regimen{
					font-size: 6;
					text-align: center;
				}

				.bordered {
					width: 100%;
					border-spacing: 0px;
					border-radius: 10px 10px 10px 10px;
					border: 1px solid #000000;

				}

				.bordered td, th{
					height: 17px;
					text-align: left;
				}

				.border-left {
					border-left: 1px solid black;
				}

				.border-right {
					border-right: 1px solid black;
				}

				.border-bottom {
					border-bottom: 1px solid black;
				}
				.padding-text{
					padding: 5px;
				}
				.comment{
					text-indent: 10px;
				}
				.bold{
					font-weight: bold;
				}
				.size6{
					font-size: 6;
				}
				.left {
					text-align: left !important;
				}

				.right {
					text-align: right !important;
				}

				.center{
					text-align: center !important;
				}
				.foot{
					padding-top: 30px;
					width: 100%;
					font-weight: bold;
				}
			</style>
		@endif
	</head>
	<body>
		{{-- Title --}}
		{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
		@include('cartera.facturas.exportar.title')
		<br>
		@yield('content')
		<footer>
			<div class="center foot">
				{{ $empresa->tercero_direccion }} {{ $empresa->empresa_municipio}} - {{ $empresa->tercero_celular }}<br>
				{{ $empresa->tercero_email }}<br>
			</div>
		</footer>
	</body>
</html>
