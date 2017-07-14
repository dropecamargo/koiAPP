@extends('inventario.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productos.index')}}">Productos</a></li>
    <li class="active">{{ $producto->id }}</li>
@stop

@section('module')
    <div class="box box-success" id="producto-show">
        <div class="box-body">
            <div class="form-group col-md-6">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>Informacion Basica</strong></h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Referencia:</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $producto->producto_referencia }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Serie:</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $producto->producto_serie }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Nombre:</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $producto->producto_nombre }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Precio Mínimo:</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{ number_format($producto->producto_precio1, 2, '.', ',') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Precio Sugerido:</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{ number_format($producto->producto_precio2, 2, '.', ',') }}
                                        </div>
                                    </div> 
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Precio Crédito:</label>
                                        </div>
                                        <div class="col-md-6">
                                            {{ number_format($producto->producto_precio3, 2, '.', ',') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="wrapper-series">
                        <div class="form-group col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Disponibilidad</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <table id="prodbode-search-table" class="table table-striped table-condensed">
                                        <tbody>
                                            @if( !$producto->producto_maneja_serie && !$producto->producto_metrado)
                                                <tr>
                                                    <th width="60%">Sucursal</th>
                                                    <th width="5%">U. Disponible</th>
                                                    <th width="5%">U. Reservadas</th>
                                                    <th width="30%">Ubicacion</th>
                                                </tr>

                                                @if( count($prodbode) == 0 )
                                                    <tr>
                                                        <th colspan="3" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                                    </tr>
                                                @endif
                                                
                                                @foreach( $prodbode as $item)
                                                    <tr>
                                                        <td>{{ $item->sucursal_nombre }}</td>
                                                        <td>{{ $item->prodbode_cantidad }}</td>
                                                        <td>{{ $item->prodbode_reservado }}</td>
                                                        <th><a class="#">Agregar</a></th>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            @if( $producto->producto_maneja_serie)
                                                <tr>
                                                    <th width="50%">Sucursal</th>
                                                    <th width="25%">U. Disponible</th>
                                                    <th width="25%">U. Reservadas</th>
                                                </tr>
                                                
                                                @if( count($prodbode) == 0 )
                                                    <tr>
                                                        <th colspan="3" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                                    </tr>
                                                @endif

                                                @foreach( $prodbode as $item)
                                                    <tr>
                                                        <td>{{ $item->sucursal_nombre }}</td>
                                                        <td>{{ $item->prodbode_cantidad }}</td>
                                                        <td>{{ $item->prodbode_reservado }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th colspan="4" class="text-center"><a class="btn get-series" id="{{ $producto->id }}">Ver series</a></th>
                                                </tr>
                                            @endif
                                            @if ($producto->producto_metrado)
                                                <tr>
                                                    <th width="60%">Sucursal</th>
                                                    <th width="20%">Rollo</th>
                                                    <th width="20%">Metros (mts)</th>
                                                </tr>

                                                @if( count($prodbode) == 0 )
                                                    <tr>
                                                        <th colspan="3" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                                    </tr>
                                                @endif

                                                @foreach( $prodbode as $item)
                                                    <tr>
                                                        <td>{{ $item->sucursal_nombre }}</td>
                                                        <td>{{ $item->rollo_rollos }}</td>
                                                        <td>{{ $item->rollo_saldo }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div id="render-series"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-md-6">
                <div class="box box-solid collapsed-box">
                    <div class="box-header">
                        <h1 class="box-title ">Atributos</h1>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Unidad de medida</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->unidadmedida_nombre }} ({{ $producto->unidadmedida_sigla }})
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Modelo</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->modelo_nombre}}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Marca</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->marca_nombre}} 
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Impuesto</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->impuesto_nombre}} - {{$producto->impuesto_porcentaje}}%
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Peso</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->producto_peso}} kg
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Largo</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->producto_largo}} cm
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Ancho</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->producto_ancho}} cm
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Alto</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->producto_alto}} cm
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">¿Maneja serie?</label>
                            </div>
                            <div class="col-md-7">
                                <input type="checkbox" id="producto_maneja_serie" name="producto_maneja_serie" value="producto_maneja_serie" disabled {{ $producto->producto_maneja_serie ? 'checked': '' }}>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">¿Producto metrado?</label>
                            </div>
                            <div class="col-md-7">
                                <input type="checkbox" id="producto_metrado" name="producto_metrado" value="producto_metrado" disabled {{ $producto->producto_metrado ? 'checked': '' }}>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">¿Producto vence?</label>
                            </div>
                            <div class="col-md-7">
                                <input type="checkbox" id="producto_vence" name="producto_vence" value="producto_vence" disabled {{ $producto->producto_vence ? 'checked': '' }}>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">¿Maneja Unidades?</label>
                            </div>
                            <div class="col-md-7">
                                <input type="checkbox" id="producto_unidad" name="producto_unidad" value="producto_unidad" disabled {{ $producto->producto_unidad ? 'checked': '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-solid collapsed-box">
                    <div class="box-header">
                        <h1 class="box-title">Clasificacion</h1>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Unidad De Negocio</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->unidadnegocio_nombre }}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Linea</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->linea_nombre}}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Categoria</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->categoria_nombre}}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">SubCategoria</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->subcategoria_nombre}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-solid collapsed-box">
                    <div class="box-header">
                        <h1 class="box-title">Costos</h1>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Costo promedio</label>
                            </div>
                            <div class="col-md-7">
                                $ {{ number_format($producto->producto_costo, 2, '.', ',') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-solid collapsed-box">
                    <div class="box-header">
                        <h1 class="box-title">Importaciones</h1>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Referecia proveedor</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->producto_ref_proveedor }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('productos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href="{{ route('productos.edit', ['productos' => $producto->id]) }}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop