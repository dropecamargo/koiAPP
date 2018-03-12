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
					<div class="col-sm-1">
    					<a class="btn btn-app" href="{{ route('terceros.index') }}" title="Ver Terceros">
    						<i class="fa fa-users"></i> Terceros
    					</a>
                    </div>

                    <div class="col-sm-1">
						<a class="btn btn-app" href="{{ route('productos.index') }}" title="Ver Productos">
							<i class="fa fa-barcode"></i> Productos
						</a>
	                </div>
				</div>
			</div>
		</div>
    </section>
@stop
