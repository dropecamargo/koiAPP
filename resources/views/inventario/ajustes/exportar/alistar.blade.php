@extends('inventario.ajustes.exportar.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
    <table class="htable" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <th width="15%">Fecha</th>
                <td width="10%">{{ $ajuste->ajuste1_fecha }}</td>
            </tr>
            <tr>
                <th width="15%">Sucursal</th>
                <td width="15%">{{ $ajuste->sucursal_nombre }}</td>

                <th class="center" width="45%">Número</th>
                <td class="left" width="15%">{{ $ajuste->ajuste1_numero }}</td>
            </tr>
            <tr>
                <th width="15%">Tipo</th>
                <td width="15%">{{ $ajuste->documentos_nombre }} - {{ $ajuste->tipoajuste_nombre }}</td>
            </tr>

            <tr>
                <th width="20%">Observaciones</th>
                <td width="80%">{{ $ajuste->ajuste1_observaciones }}</td>
            </tr>
        </tbody>
    </table>
    <br>

    {{-- Detalle --}}
    <table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th colspan="5"></th>
                <th class="center" colspan="2">Metros</th>
            </tr>
            <tr>
                <th width="15%">Referencia</th>
                <th width="30%">Nombre</th>
                <th width="15%">Ubicación</th>
                <th class="center" width="5%">Entrada</th>
                <th class="center" width="5%">Salida</th>
                <th class="center" width="5%">Entrada</th>
                <th class="center" width="5%">Salida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as $item)
            <tr>
                <td>{{ $item->producto_serie }}</td>
                <td>{{ $item->producto_nombre }}</td>
                <td>{{ $item->ubicacion_nombre }}</td>
                <td class="center">{{ $item->inventario_entrada }}</td>
                <td class="center">{{ $item->inventario_salida }}</td>
                <td class="center">{{ $item->inventario_metros_entrada }}</td>
                <td class="center">{{ $item->inventario_metros_salida }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="center foot">
        <b>Elaboró </b>   {{ $inventario->pluck('tercero_nombre')->first() }} - {{$inventario->pluck('tercero_nit')->first()}} <br>
        <b>F. Elaboró </b>   {{ $inventario->pluck('inventario_fh_elaboro')->first() }} <br>
        <b>F. impresión</b> {{ date('Y-m-d h:m:s') }}
    </div>
@stop