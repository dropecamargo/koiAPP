@extends('layout.layout')

@section('title') Sabana de ventas @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte sabana de ventas con costo
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte sabana de ventas con costo</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-primary">
	    	<form action="{{ route('rsabanaventascostos.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-offset-3">
                            <label for="filter_regional" class="control-label">Regionales</label>
                            <select name="filter_regional[ ]" class="form-control select2-default" multiple="multiple">
                                <option value="0">TODAS</option>
                                @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                                    <option value="{{ $key }}"> {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
					<div class="row">
						<div class="form-group col-md-2 col-md-offset-4">
                            <label for="filter_year_begin" class="control-label">Año inicial</label>
							<select name="filter_year_begin" class="form-control">
								@for( $i=config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</div>
						<div class="form-group col-md-2">
                            <label for="filter_month_begin" class="control-label">Mes inicial</label>
							<select name="filter_month_begin" class="form-control">
								@foreach( config('koi.meses') as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-2 col-md-offset-4">
                            <label for="filter_year_end" class="control-label">Año final</label>
							<select name="filter_year_end" class="form-control">
								@for( $i=config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</div>
						<div class="form-group col-md-2">
                            <label for="filter_month_end" class="control-label">Mes final</label>
							<select name="filter_month_end" class="form-control">
								@foreach( config('koi.meses') as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
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
