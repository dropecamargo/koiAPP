@extends('layout.layout')

@section('title') Municipios @stop

@section('content')
    <section class="content-header">
		<h1>
			Municipios <small>Administración de municipios</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Municipios</li>
		</ol>
    </section>

	<section class="content">
		<div class="box box-primary" id="municipios-main">
			<div class="box-body table-responsive">
				<table id="municipios-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Código Dpto.</th>
			                <th>Departamento</th>
			                <th>Código Mpio.</th>
			                <th>Municipio</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
    </section>
@stop
