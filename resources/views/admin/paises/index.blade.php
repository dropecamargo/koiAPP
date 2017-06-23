@extends('layout.layout')

@section('title') Paises @stop

@section('content')
    <section class="content-header">
		<h1>
			Paises <small>Administración de paises</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Paises</li>
		</ol>
    </section>

	<section class="content">
		<div id="paises-main">
			<div class="box box-success">
				<div class="box-body table-responsive">
					<table id="paises-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Id</th>
				                <th>Código</th>
				                <th>País</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
    </section>    
@stop
