    @extends('inventario.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productos.index')}}">Productos</a></li>
    <li class="active">{{ $producto->producto_codigo }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Serie</label>
                    <div>{{ $producto->producto_serie }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Referencia</label>
                    <div>{{ $producto->producto_referencia }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Referecia Proveedor</label>
                    <div>{{ $producto->producto_ref_proveedor }}</div>
                </div> 
                <div class="form-group col-md-3">
                    <label class="control-label">Código De Barras</label>
                    <div>{{ $producto->producto_barras }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $producto->producto_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Unidad De Negocio</label>
                    <div>{{ $producto->unidadnegocio_nombre }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Linea</label>
                    <div>{{ $producto->linea_nombre}} </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Unidad de medida</label>
                    <div>{{ $producto->unidadmedida_nombre }} ({{ $producto->unidadmedida_sigla }})</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Categoria</label>
                    <div>{{ $producto->categoria_nombre}} </div>
                </div>
                 <div class="form-group col-md-3">
                    <label class="control-label">SubCategoria</label>
                    <div>{{ $producto->subcategoria_nombre}} </div>
                </div>
                
                <div class="form-group col-md-3">
                    <label class="control-label">Modelo</label>
                    <div>{{ $producto->modelo_nombre}} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Marca</label>
                    <div>{{ $producto->marca_nombre}} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Impuesto</label>
                    <div>{{ $producto->impuesto_nombre}} - {{$producto->impuesto_porcentaje}}%</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Peso</label>
                    <div>{{ $producto->producto_peso}} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Largo</label>
                    <div>{{ $producto->producto_largo}} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Ancho</label>
                    <div>{{ $producto->producto_ancho}} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Alto</label>
                    <div>{{ $producto->producto_alto}} </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">¿Maneja serie?</label>
                    <div>
                        <input type="checkbox" id="producto_maneja_serie" name="producto_maneja_serie" value="producto_maneja_serie" disabled {{ $producto->producto_maneja_serie ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">¿Producto metrado?</label>
                    <div>
                        <input type="checkbox" id="producto_metrado" name="producto_metrado" value="producto_metrado" disabled {{ $producto->producto_metrado ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">¿Producto vence?</label>
                    <div>
                        <input type="checkbox" id="producto_vence" name="producto_vence" value="producto_vence" disabled {{ $producto->producto_vence ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">¿Maneja Unidades?</label>
                    <div>
                        <input type="checkbox" id="producto_unidad" name="producto_unidad" value="producto_unidad" disabled {{ $producto->producto_unidad ? 'checked': '' }}>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Precio Mínimo</label>
                    <div class="text-left">$ {{ number_format($producto->producto_precio1, 2, '.', ',') }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Precio Sugerido</label>
                    <div class="text-left">$ {{ number_format($producto->producto_precio2, 2, '.', ',') }}</div>
                </div> 
                <div class="form-group col-md-3">
                    <label class="control-label">Precio Crédito</label>
                    <div class="text-left">$ {{ number_format($producto->producto_precio3, 2, '.', ',') }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Costo promedio</label>
                    <div class="text-left">$ {{ number_format($producto->producto_costo, 2, '.', ',') }}</div>
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