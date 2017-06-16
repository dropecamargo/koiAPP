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
    <script type="text/template" id="add-gestioncobro-item-tpl">
    	<td><%- conceptocob_nombre %></td>
    	<td><%- gestioncobro_fh %></td>
    	<td><%- gestioncobro_proxima %></td>
    	<td><%- gestioncobro_observaciones %></td>
    	<td><%- usuario_nombre %></td>
    </script>

@stop
