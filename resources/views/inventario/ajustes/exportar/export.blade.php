@extends('inventario.ajustes.exportar.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<div class="container-ajuste">
		<tr>
			<th width="78%" class="left"></th>
			<th width="22%" class="center">{{ $ajuste->ajuste1_numero }}</th>
		</tr>
	</div>

                <div class="row"> 
                     <b>Fecha</b>
                    <div class="form-group col-md-3">
                        <div>{{ $ajuste->ajuste1_fecha }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Sucursal</label>
                        <div>{{ $ajuste->sucursal_nombre }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Número</label>
                        <div>{{ $ajuste->ajuste1_numero }}</div>
                    </div>
                </div>
                <div class="row"> 
                     <div class="form-group col-md-3">
                        <label class="control-label">Tipo Ajuste</label>
                        <div>{{ $ajuste->tipoajuste_nombre }}</div>
                    </div> 
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label class="control-label">Obsercaciones</label>
                        <div>{{ $ajuste->ajuste1_observaciones }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label class="control-label">Elaboró: </label>
                        <div>
                            <a href="{{ route('terceros.show', ['terceros' =>  $ajuste->ajuste1_usuario_elaboro ]) }}" title="Ver tercero">{{ $ajuste->tercero_nit }} </a> - {{ $ajuste->tercero_nombre }}
                        </div>
                    </div>
                </div>
                <div id="detalle-ajuste" class="box box-success">
                    <div class="table-responsive no-padding">
                        <table id="browse-detalle-ajuste-list" class="table table-hover table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="15%">Referencia</th>
                                    <th width="40%" align="left">Nombre</th>
                                    <th width="10%">Cant. Entrada</th>
                                    <th width="10%">Cant. Salida</th>
                                    <th width="10%">Costo</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Render content detalle ajuste --}}
                            </tbody>
                        </table>
                    </div>
                </div>


    {{--<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th class="left"></th>
			<th class="left">{{ $ajuste->tercero_nombre }}</th>
		</tr>

		<tr>
			<th width="12%"></th>
			<th width="30%" class="left">{{ $ajuste->tercero_direccion }}</th>

			<th width="12%"></th>
			<th width="40%" class="right">{{ $ajuste->municipio_nombre }}</th>

			<th colspan="2"></th>
			<th width="10%" class="center">{{ $ajuste->ajuste1_primerpago }}</th>
			<th width="10%" class="center">xx - xx - xx</th>
		</tr>

		<tr>
			<th width="10%"></th>
			@if( !empty($ajuste->tercero_telefono1) )
				<th width="20%" class="left">{{ $ajuste->tercero_telefono1 }}</th>
			@elseif ( !empty($ajuste->tercero_telefono2) )
				<th width="20%" class="left">{{ $ajuste->tercero_telefono2 }}</th>
			@elseif ( !empty($ajuste->tercero_celular) )
				<th width="20%" class="left">{{ $ajuste->tercero_celular }}</th>
			@else 
				<th width="20%" class="left"></th>
			@endif


			<th width="10%"></th>
			<th width="20%" class="left">{{ $ajuste->tercero_fax }}</th>				

			<th width="10%"></th>
			<th width="20%" class="left">{{ $ajuste->tercero_nit }}</th>	

			<th width="10%"></th>
			<th width="20%" class="right">xxxxx</th>			
		</tr>
	</table>

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%" class="left"></th>
				<th width="5%" class="left"></th>
				<th width="50%" class="center"></th>
				<th width="15%" class="center"></th>
				<th width="15%" class="center"></th>
			</tr>
		</thead>
		<tbody>
			@if(count($detalle) > 0)
				@foreach($detalle as $item)
					<tr>
						<td class="left">{{ $item->producto_serie }}</td>
						<td class="center">{{ $item->factura2_cantidad }}</td>
						<td class="left">{{ $item->producto_nombre }}</td>
						<td class="right">{{ number_format($item->factura2_costo,2,',','.') }}</td>
						<td class="right">{{ number_format($item->factura2_costo,2,',','.') }}</td>
					</tr>
				@endforeach
				@if( count($detalle) < 14)
					@for($i = count($detalle); $i < 14; $i++)
						<tr>
							<td colspan="5"></td>
						</tr>
					@endfor
				@endif
			@endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" rowspan="8"></td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format($item->factura1_bruto,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format($factura->factura1_descuento,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format($factura->factura1_iva,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format( 0 ,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format( 0 ,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format( 0 ,2,',','.') }}</td>
			</tr>
			<tr>
				<td class="right"></td>
				<td class="right">{{ number_format($factura->factura1_total,2,',','.') }}</td>
			</tr>
		</tfoot>
	</table>--}}
@stop