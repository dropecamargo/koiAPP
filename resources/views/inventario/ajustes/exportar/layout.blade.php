<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		{{-- Include css pdf --}}
		@if($type == 'pdf')
			<style type="text/css">
				body {
					font-size: 9;
					font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
					font-weight: normal;
				    margin: 0px 0px 0px 0px:
				}

				.tbtitle {
					width: 100%;
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
					border-bottom: 1px solid black;
				}

				.title{
					font-size: 10;
					font-weight: bold;
					text-align: center;
				}
				.rtable {
					width: 100%;
				    border-collapse: collapse;
				}

				.rtable th {
					padding-left: 2px;
				}

				.rtable td, th {
					height: 15px;
				}

				.rtable tbody {
					height: 400px;
				}

				.rtable tr:nth-child(even) {
					background-color: #f2f2f2
				}

				.htable {
					margin-top: 25px;
					width: 100%;
					font-size: 9;
				    border-collapse: collapse;
				}

				.htable {
					width: 100%;
				}

				.htable td, th {
					text-align: left;
				}

				.left {
					text-align: left;
				}

				.right {
					text-align: right;
				}

				.center{
					text-align: center;
				}
				.foot{
					padding-top: 100px;
					width: 100%;
					font-size: 7;
				}
			</style>
		@endif
	</head>
	<body>

		{{-- Title --}}
		{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
		@include('inventario.ajustes.exportar.title')
		<br/>

		@yield('content')
	</body>
</html>