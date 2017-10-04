@extends('layout.layout')

@section('title') Reporte movimiento de producto @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte movmiento de producto
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte movmiento de producto</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rmovimientosproductos.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body" id="wrapper-body">
	                <div class="row">
						<label class="control-label col-md-1 col-md-1  col-md-offset-2">Producto</label>
	                    <div class="form-group col-sm-2">
	                        <div class="input-group input-group-sm">
	                            <span class="input-group-btn">
	                                <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component"  data-field="producto_serie">
	                                    <i class="fa fa-barcode"></i>
	                                </button>
	                            </span>
	                            <input id="producto_serie" placeholder="Serie" class="form-control producto-koi-component" name="producto_serie" type="text" maxlength="15" data-wrapper="wrapper-body" data-name="producto_nombre" required> 
	                        </div>
	                    </div>
	                    <div class="col-sm-5 ">
	                        <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
	                    </div>
	                </div>
					<div class="row">
	                    <label for="filter_sucursal" class="col-sm-1 control-label col-md-offset-2">Sucursal</label>
	                    <div class="form-group col-sm-3">
	                        <select name="filter_sucursal" id="filter_sucursal" class="form-control select2-default-clear">
		                        @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
		                            <option  value="{{ $key }}">{{ $value }}</option>
		                        @endforeach
	                        </select>
	                    </div>
					</div>
					<div class="row">
						<label for="filter_fecha_inicio" class="col-sm-1 control-label col-md-offset-2">Fecha</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_inicio" name="filter_fecha_inicio" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
					</div>
					<div class="row">
						<label for="filter_fecha_fin" class="col-sm-1 control-label col-md-offset-2">Fecha</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_fin" name="filter_fecha_fin" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker" required>
	                        </div>
	                    </div>
					</div>
				</div>
				<div class="box-footer">
					<div class="row">
						<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
							<button type="submit" class="btn btn-default btn-sm btn-block btn-export-xls-koi-component">
								<i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
							</button>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-6">
							<button type="submit" class="btn btn-default btn-sm btn-block btn-export-pdf-koi-component">
								<i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
@stop