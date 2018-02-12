@extends('layout.layout')

@section('title') Dashboard @stop

@section('content')
    <section class="content-header">
        <h1>
            Dashboard <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>
	<section class="content">
		<div class="box box-primary">
			<div class="box-body">
                <div class="row">
					<div class="col-md-1">
    					<a class="btn btn-app btn-koi-search-tercero-component-table" data-render="show" title="Ver Terceros">
    						<i class="fa fa-users"></i> Terceros
    					</a>
                    </div>

                    <div class="col-md-1">
						<a class="btn btn-app btn-koi-search-producto-component" data-render="show" title="Ver Productos">
							<i class="fa fa-barcode"></i> Productos
						</a>
	                </div>
				</div>
			</div>
		</div>
    </section>
@stop
