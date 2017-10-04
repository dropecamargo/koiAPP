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
	    <div class="box box-success">
	    	<form action="{{ route('rexistencias.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-offset-4 col-md-4">
							<label for="sub_categoria" class="control-label">Sub categoria</label>
							<select name="sub_categoria" id="sub_categoria" class="form-control select2-default-clear">
								@foreach( App\Models\Inventario\SubCategoria::getSubCategorias() as $key => $value)
								    <option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="box box-solid">
						<div class="box-header whit-border col-md-offset-6"><h4><strong>Sucursales</strong></h4></div>
						<div class="box-body col-md-offset-1">
							@foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
								@if($value != '')
									<div class="form-group col-md-3">
										<label class="checkbox-inline" for="check_sucursal_{{$key}}">
											<input type="checkbox" name="check_sucursal_{{$key}}" value="{{$key}}"> {{$value}}
										</label>
									</div>
								@endif
							@endforeach
						</div>
					</div>
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