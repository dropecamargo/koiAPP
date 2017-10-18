@extends('layout.layout')

@section('title') Reporte ordenes abiertas @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte ordenes abiertas
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte ordenes abiertas</li>
		</ol>
    </section>

   	<section class="content">

	    <div class="box box-success">
	    	<form action="{{ route('rordenesabiertas.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body">
                 	<div class="row">
                        <label for="filter_serie" class="col-md-1 control-label">Producto</label>
                        <div class="form-group col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="filter_serie" >
                                        <i class="fa fa-barcode"></i>
                                    </button>
                                </span>
                                <input id="filter_serie" placeholder="Serie" class="form-control producto-koi-component" name="filter_serie" type="text" maxlength="15" data-tercero="true" data-orden="true" data-name="filter_nombre_producto">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input id="filter_nombre_producto" name="filter_nombre_producto" placeholder="Nombre producto" class="form-control input-sm" type="text" readonly>
                        </div>
                    </div>
	                <div class="row">
	                    <label for="filter_tercero" class="col-md-1 control-label">Cliente</label>
	                    <div class="form-group col-md-3">
	                        <div class="input-group input-group-sm">
	                            <span class="input-group-btn">
	                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="filter_tercero">
	                                    <i class="fa fa-user"></i>
	                                </button>
	                            </span>
	                            <input id="filter_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="filter_tercero" type="text" maxlength="15" data-name="filter_tercero_nombre" data-activo="true">
	                        </div>
	                    </div>
	                    <div class="col-md-6 col-xs-12">
	                        <input id="filter_tercero_nombre" name="filter_tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" readonly>
	                    </div>
	                </div>
					<div class="row"> 
                    	<label for="filter_technical" class="col-sm-1 control-label">Técnico</label>
	                    <div class="form-group col-sm-3">
	                        <select name="filter_technical" id="filter_technical" class="form-control select2-default">
	                        @foreach( App\Models\Base\Tercero::getTechnicals() as $key => $value)
	                            <option  value="{{ $key }}">{{ $value }}</option>
	                        @endforeach
	                        </select>
	                    </div>
                	</div>
					<div class="row">
						<label for="filter_sucursal" class="col-sm-1 control-label">Sucursales</label>
	                    <div class="form-group col-sm-4">
							<select name="filter_sucursal[ ]" class="form-control select2-default" multiple="multiple">
	                        	<option value="0">TODAS</option>
								@foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
		                        	<option value="{{ $key }}"> {{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-md-2 col-sm-6 col-xs-6 col-md-offset-5">
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