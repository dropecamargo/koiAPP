@extends('layout.layout')

@section('title') Reporte cartera edades @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte edades de cartera
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte edades de cartera</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-primary">
	    	<form action="{{ route('rcarteraedades.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
					    <label for="filter_tercero" class="col-md-1 col-md-1 control-label">Cliente</label>
					    <div class="form-group col-md-2">
					        <div class="input-group input-group-sm">
					            <span class="input-group-btn">
					                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="filter_tercero">
					                    <i class="fa fa-user"></i>
					                </button>
					            </span>
					            <input id="filter_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="filter_tercero" type="text" maxlength="15" data-name="filter_terecero_nombre" required>
					        </div>
					    </div>
					    <div class="col-md-6 col-xs-12">
					        <input id="filter_terecero_nombre" name="filter_terecero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" readonly required>
					    </div>
					</div>
					<div class="row">
	                    <label for="filter_mes" class="col-sm-1 control-label">Cierre</label>
						<div class="form-group col-sm-2">
							<select name="filter_mes" class="form-control">
								@foreach( config('koi.meses') as $key => $value)
									<option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-sm-2">
							<input type="number" name="filter_ano" value="{{ date('Y') }}" maxlength="4" data-minlength="4" class="form-control">
						</div>

	                    <label for="filter_tipo" class="col-sm-1 control-label">Tipo</label>
	                    <div class="form-group col-sm-3">
	                        <select name="filter_tipo" class="form-control select2-default-clear">
	                        	<option value="D">DETALLADO</option>
	                        	<option value="R">RESUMIDO</option>
	                        </select>
	                    </div>
					</div>
					<div class="row">
						<label for="filter_sucursal" class="col-sm-1 control-label">Sucursales</label>
	                    <div class="form-group col-sm-4">
							<select name="filter_sucursal[ ]" class="form-control select2-default" multiple="multiple">
								@foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
		                        	<option value="{{ $key }}"> {{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
							<button type="submit" class="btn btn-default btn-sm btn-block btn-export-xls-koi-component">
								<i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
@stop
