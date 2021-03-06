@extends('layout.layout')

@section('title') Reporte existencias @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte existencias de producto
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte existencias de producto</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-primary">
	    	<form action="{{ route('rexistencias.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-4 col-md-offset-4">
							<label for="filter_line" class="control-label">Linea</label>
							<select name="filter_line[]" id="filter_line" class="form-control select2-default" multiple="multiple">
                                <option value="0">TODAS</option>
								@foreach( App\Models\Inventario\Linea::getlineas() as $key => $value)
								    <option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
	                    <div class="form-group col-md-4 col-md-offset-4">
                            <label for="filter_sucursal" class="control-label">Sucursales</label>
							<select name="filter_sucursal[ ]" class="form-control select2-default" multiple="multiple">
                                <option value="0">TODAS</option>
								@foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
		                        	<option value="{{ $key }}"> {{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-md-2 col-md-offset-4 col-md-6 col-xs-6">
							<button type="submit" class="btn btn-default btn-sm btn-block btn-export-xls-koi-component">
								<i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
							</button>
						</div>
						<div class="col-md-2 col-md-6 col-xs-6">
							<button type="submit" class="btn btn-default btn-sm btn-block btn-export-pdf-koi-component">
								<i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
							</button>
						</div>
					</div>
				</div>
			</form>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
		</div>
	</section>
@stop
