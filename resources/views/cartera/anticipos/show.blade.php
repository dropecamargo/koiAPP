@extends('cartera.anticipos.main')

@section('breadcrumb')
    <li><a href="{{ route('anticipos.index')}}">Anticipos</a></li>
    <li class="active">{{ $anticipo1->id }}</li>
@stop

@section('module')
	<div class="box box-success" id="anticipo-show">
		<div class="box-body">
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $anticipo1->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Numero</label>
                    <div>{{ $anticipo1->anticipo1_numero }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $anticipo1->anticipo1_fecha }}</div>
                </div>
			</div>
    		<div class="row">
		        <div class="form-group col-md-12">
                    <label class="control-label">Cliente</label>
                    <div>{{ $anticipo1->tercero_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $anticipo1->anticipo1_tercero ]) }}" title="Ver tercero">{{ $anticipo1->tercero_nit }} </a> </div>
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-md-3">
        			<label class="control-label">Cuenta Banco</label>
        			<div>{{ $anticipo1->cuentabanco_nombre }}</div>
        		</div>        			
        		<div class="form-group col-md-2">
        			<label class="control-label">Valor</label>
        			<div>$ {{number_format($anticipo1->anticipo1_valor )}}</div>
        		</div>
        		<div class="form-group col-md-2">
        			<label class="control-label">Saldo</label>
        			<div>$ {{number_format($anticipo1->anticipo1_saldo)}}</div>
        		</div>
        	</div>
    		<div class="row">
		        <div class="form-group col-md-12">
                    <label class="control-label">Vendedor</label>
                    <div>{{ $anticipo1->vendedor_nombre }} - <a href="{{ route('terceros.show', ['terceros' =>  $anticipo1->anticipo1_vendedor]) }}" title="Ver tercero">{{ $anticipo1->vendedor_nit }} </a> </div>
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group+ col-md-12">
        			<label class="control-label">Observaciones</label>
        			<div>{{ $anticipo1->anticipo1_observaciones }}</div>
        		</div>
        	</div>
        	<div class="box box-success">
        		<div class="table-responsive no-padding">
                    <table table id="browse-anticipo2-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Medio de pago</th>
                                <th>Banco</th>
                                <th>Numero</th>
                                <th>Fecha</th>
                                <th>Valor</th>
                            </tr>
                        </thead>   
                        <tbody>
                            {{-- Render content anticipo2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3"></th>
                                <th class="text-left">Total</th>
                                <th class="text-right"  id="total">0</th>
                            </tr>
                        </tfoot>
                    </table>
        		</div>
        	</div>

        	<div class="box box-success">
        		<div class="table-responsive no-padding">
                    <table table id="browse-anticipo3-list" class="table table-hover table-bordered" cellspacing="0">
	                    <thead>
	                        <tr>
	                            <th>Concepto</th>
	                            <th>Naturaleza</th>
	                            <th>Valor</th>
	                        </tr>
	                    </thead>   
	                    <tbody>
	                        {{-- Render content anticipo3 --}}
	                    </tbody>
	                    <tfoot>
	                        <tr>
	                            <th colspan="1"></th>
	                            <th class="text-left">Total</th>
	                            <th class="text-right"  id="total">0</th>
	                        </tr>
	                    </tfoot>
	                </table>
        		</div>
        	</div>
		</div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('anticipos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
	</div>
@stop