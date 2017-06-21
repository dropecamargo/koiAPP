@extends('cartera.chequesdevueltos.main')

@section('breadcrumb')
    <li><a href="{{ route('cheques.index')}}">Cheque devuelto</a></li>
    <li class="active">{{ $chdevuelto->id }}</li>
@stop

@section('module')
	<div class="box box-success">
		<div class="box-body"> 
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $chdevuelto->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Número</label>
                    <div>{{ $chdevuelto->chdevuelto_numero }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $chdevuelto->chposfechado1_fecha }}</div>
                </div>
			</div>
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Cliente</label>
                    <div>{{ $chdevuelto->tercero_nombre }}</div>
                </div>
        	  	<div class="form-group col-md-3">
                    <label class="control-label">Girador</label>
                    <div>{{ $chdevuelto->chposfechado1_girador }}</div>
                </div>
			</div>
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Banco</label>
                    <div>{{ $chdevuelto->banco_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">N° cheque</label>
                    <div>{{ $chdevuelto->chposfechado1_ch_numero }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Valor</label>
                    <div>{{ number_format($chdevuelto->chposfechado1_valor) }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha cheque</label>
                    <div>{{ $chdevuelto->chposfechado1_ch_fecha }}</div>
                </div>
				<div class="form-group col-md-2">
					<label class="control-label">¿ Centro de riesgo ?</label>
					<div>
						@if($chdevuelto->chposfechado1_central_riesgo == 1)
							SI
						@else
							NO
						@endif	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Observaciones</label>
					<div>{{ $chdevuelto->chposfechado1_observaciones }}</div>
				</div>
			</div>
		</div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('chequesdevueltos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>	
	</div>
@stop