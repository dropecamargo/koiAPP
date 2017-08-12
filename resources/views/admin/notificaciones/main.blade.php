@extends('layout.layout')

@section('title') Notificaciones @stop

@section('content')
    <section class="content-header">
		<h1>
			Tus notificaciones
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li>Notificaciones</li>
		</ol>
    </section>

   	<section class="content">
        <div class="box box-success" id="notification-main">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
	            	<div class="row">
	                    <label for="search_fecha" class="col-md-1 control-label">Fecha</label>
	                    <div class="col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="search_fecha" placeholder="Fecha" class="form-control input-sm datepicker" name="search_fecha" type="text">
                            </div>
	                    </div>

	               		<label for="search_typenotification" class="col-md-2 control-label">Tipo notificación</label>
	                    <div class="col-md-3 text-left">
	                        <select name="search_typenotification" id="search_typenotification" class="form-control select2-default-clear">
	                            @foreach( App\Models\Base\TipoNotificacion::getTypes() as $key => $value)
	                                <option value="{{ $key }}">{{ $value }}</option>
	                            @endforeach
	                        </select>
	                    </div>

                        <label for="search_estado" class="col-md-1 control-label">Estado</label>
	                    <div class="col-md-3 text-left">
	                        <select name="search_estado" id="search_estado" class="form-control">
                                <option value selected>Todas</option>
                                <option value="F">Pendientes</option>
                                <option value="T">Vistas</option>
	                        </select>
	                    </div>
	                </div><br>
	                <div class="row">
	                	<div class="col-md-offset-4 col-sm-2 col-xs-4">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
	                	<div class="col-md-2 col-xs-4">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
	                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="box box-solid">
                    <div class="box-body" id="spinner-notification">
                        <ul class="notifications-list" id="notifications-list">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</section>

    <script type="text/template" id="add-notification-tpl">
        <div class="notification-text">
            <div class="row">
                <div class="col-md-6 text-left">
                    <i class="fa fa-phone text-green"><%- notificacion_titulo %></i>
                </div>
                <div class="col-md-6 text-right">
                    <span class="notification-fecha"><%- nfecha %></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class="notification-description text-black"><%- notificacion_descripcion %></span>
                </div>
            </div>
        </div>
    </script>
@stop
