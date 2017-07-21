<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		{{-- Include css pdf --}}
		@if($type == 'pdf')
			<style type="text/css">
				body {
					font-size: 5;
					font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
					font-weight: normal;
				    margin: 0px 0px 0px 25px:
				}

				@page{
					/*size: letter;*/
					size: A5 landscape;
				}

				.container-factura{
					display: table;
					font-size: 8;
					width: 100%;
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

				.htable {
					margin-top: 25px;
					width: 100%;
					font-size: 5;
				    border-collapse: collapse;
				}

				.htable th {
					padding-left: 2px;
				}

				.htable td, th {
					height: 14px;
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
			</style>
		@endif
	</head>
	<body>
		@yield('content')
	</body>
</html>