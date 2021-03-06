@extends('layout.layout')

@section('title') Reporte plan de cuentas @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte plan de cuentas <small>P.U.C</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte plan de cuentas</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-primary" id="empresa-create">
	    	<form action="{{ route('rplancuentas.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-reporte-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-offset-5 col-md-2">
							<label for="nivel" class="control-label">Nivel</label>
							<select name="nivel" id="nivel" class="form-control select2-default-clear">
								<option value="" selected></option>
								@foreach( config('koi.contabilidad.plancuentas.niveles') as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
                    <div class="box-footer">
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
