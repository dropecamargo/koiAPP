@extends('cartera.cheques.main')

@section('breadcrumb')
    <li><a href="{{ route('cheques.index')}}">Cheque posfechado</a></li>
    <li class="active">{{ $chposfechado1->id }}</li>
@stop

@section('module')
	<div class="box box-success" id="cheque-show">
		<div class="box-body"> 
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $chposfechado1->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Número</label>
                    <div>{{ $chposfechado1->chposfechado1_numero }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha</label>
                    <div>{{ $chposfechado1->chposfechado1_fecha }}</div>
                </div>
                @if( $chposfechado1->chposfechado1_activo )
                    <div class="form-group col-md-5">
                        <div class="dropdown pull-right">
                        <label class="label label-success">ESTADO: ACTIVO</label>
                            <a href="#" class="dropdown-toggle a-color" data-toggle="dropdown">Opciones <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="#" class="anular-cheque">
                                        <i class="fa fa-ban"></i>Anular cheque
                                    </a>
                                    <a role="menuitem" tabindex="-1" href="#" class="devolver-cheque">
                                        <i class="fa fa-reply"></i>Devolver cheque
                                    </a>
                                </li>
                            </ul>
                        </div>           
                    </div>
                @elseif( $chposfechado1->chposfechado1_devuelto )
                    <div class="form-group col-md-5">
                        <label class=" label label-default col-md-3 col-md-offset-9">CHEQUE DEVUELTO</label>
                    </div>
                @elseif( $chposfechado1->chposfechado1_anulado )
                    <div class="form-group col-md-5">
                        <label class="label label-danger col-md-3 col-md-offset-9">CHEQUE ANULADO</label>          
                    </div>
                @endif
			</div>
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Cliente</label>
                    <div>{{ $chposfechado1->tercero_nombre }}</div>
                </div>
        	  	<div class="form-group col-md-3">
                    <label class="control-label">Girador</label>
                    <div>{{ $chposfechado1->chposfechado1_girador }}</div>
                </div>
			</div>
			<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Banco</label>
                    <div>{{ $chposfechado1->banco_nombre }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">N° cheque</label>
                    <div>{{ $chposfechado1->chposfechado1_ch_numero }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Valor</label>
                    <div>{{ number_format($chposfechado1->chposfechado1_valor) }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha cheque</label>
                    <div>{{ $chposfechado1->chposfechado1_ch_fecha }}</div>
                </div>
				<div class="form-group col-md-2">
					<label class="control-label">¿ Centro de riesgo ?</label>
					<div>
						@if($chposfechado1->chposfechado1_central_riesgo == 1)
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
					<div>{{ $chposfechado1->chposfechado1_observaciones }}</div>
				</div>
			</div>
			         <!-- table table-bordered table-striped -->
            <div class="box-body table-responsive no-padding">
                <table id="browse-cheque-list" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Documento</th>
                            <th>Factura Numero</th>
                            <th>Cuota</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                            {{-- Render content chposfechado2 --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <th class="text-left">Total</th>
                            <th class="text-right" id="total">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
		</div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('cheques.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>	
	</div>
    <script type="text/template" id="cheque-anular-confirm-tpl">
        <p>¿Está seguro que desea anular el cheque posfechado número <b> <%- id %> </b>?</p>
    </script>
    <script type="text/template" id="cheque-devolver-confirm-tpl">
        <p>¿Está seguro que desea devolver el cheque posfechado número <b> <%- id %> </b>?</p>
    </script>

    <script type="text/template" id="koi-select-causa">
        <div class="row">
            <div class="form-group col-sm-12">
                <label class="control-label"> Causa de devolución ? </label>
                <select name="chdevuelto_causal" id="chdevuelto_causal" class="form-control select2-default" required>
                    @foreach( App\Models\Cartera\Causal::getCausales() as $key => $value)
                        <option  value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>  
        </div>
    </script>
@stop