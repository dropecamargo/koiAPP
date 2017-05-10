@extends('layout.layout')

@section('title') Terceros @stop

@section('content')
    <section class="content-header">
		<h1>
			Terceros <small>Administración de terceros</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			@yield('breadcrumb')
		</ol>
    </section>

	<section class="content">
    	@yield('module')
    </section>    

    <script type="text/template" id="add-tercero-cartera-tpl">
		<td><%- factura1_numero %></td>
	    <td><%- factura1_prefijo %></td>
	    <td><%- factura3_cuota %></td>
	    <td><%- moment(factura1_fh_elaboro).format('YYYY-MM-DD') %></td>
		<td><%- factura3_vencimiento %></td>
		<td><%- days %></td>
	    <td class="text-right"><%- window.Misc.currency(factura3_saldo) %></td>
	</script>
@stop
