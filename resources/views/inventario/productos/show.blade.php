@extends('inventario.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productos.index')}}">Producto</a></li>
    <li class="active">{{ $producto->id }}</li>
@stop
@section('module')
    <div class="box box-primary" id="producto-show">
        <div class="box-body">
            <div class="form-group col-md-6">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>Información Básica</strong></h3>
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
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>Disponibilidad</strong></h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table id="prodbode-search-table" class="table table-striped table-condensed" cellspacing="0">
                                    <tbody>
                                        <!-- Producto serie -->
                                        @if( $producto->producto_maneja_serie)
                                            <tr>
                                                <th width="60%">Sucursal</th>
                                                <th>Disponible</th>
                                                <th>Reservadas</th>
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
                                                <th colspan="3" class="text-center"><a class="btn get-info-availability">Ver series</a></th>
                                            </tr>
                                            @if( $producto->producto_maneja_serie && $producto->producto_referencia == $producto->producto_serie)
                                                <tr>
                                                    <th colspan="3" class="text-center"><a class="btn add-series">Agregar serie</a></th>
                                                </tr>
                                            @endif
                                             <table id="browse-prodbode-table" class="table table-striped table-condensed" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="30%">Sucursal</th>
                                                        <th width="20%">Serie</th>
                                                        <th width="30%">Nombre</th>
                                                        <th width="20%">Ubicación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{--Render series--}}
                                                </tbody>
                                            </table>
                                        <!-- Producto metrado -->
                                        @elseif ($producto->producto_metrado)
                                            <tr>
                                                <th width="60%">Sucursal</th>
                                                <th width="20%">Disponible</th>
                                                <th width="20%">Reservadas</th>
                                            </tr>

                                            @if( count($prodbode) == 0 )
                                                <tr>
                                                    <th colspan="3" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                                </tr>
                                            @endif

                                            @foreach( $prodbode as $item)
                                                <tr>
                                                    <td>{{ $item->sucursal_nombre }}</td>
                                                    <td>{{ $item->prodbode_metros }} (Mts)</td>
                                                    <td>{{ $item->prodbode_reservado }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="4" class="text-center"><a class="btn get-info-availability">Ver rollos</a></th>
                                            </tr>
                                             <table id="browse-prodbode-table" class="table table-striped table-condensed" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="60%">Sucursal</th>
                                                        <th width="20%">Rollos</th>
                                                        <th width="20%">Ubicación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{--Render series--}}
                                                </tbody>
                                            </table>
                                        <!-- Producto vence-->
                                        @elseif($producto->producto_vence)
                                            <tr>
                                                <th width="60%">Sucursal</th>
                                                <th width="20%">Disponible</th>
                                                <th width="20%">Reservadas</th>
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
                                                <th colspan="3" class="text-center"><a class="btn get-info-availability">Ver ubicaciones</a></th>
                                            </tr>
                                             <table id="browse-prodbode-table" class="table table-striped table-condensed" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="60%">Sucursal</th>
                                                        <th width="20%">Ubicación</th>
                                                        <th width="5%">Cant</th>
                                                        <th width="15%">Vencimiento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{--Render vencimientos--}}
                                                </tbody>
                                            </table>
                                        <!--Producto normal-->
                                        @else
                                            <tr>
                                                <th width="60%">Sucursal</th>
                                                <th width="20%">Disponible</th>
                                                <th width="20%">Reservadas</th>
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
                                                <th colspan="4" class="text-center"><a class="btn get-info-availability">Ver ubicaciones</a></th>
                                            </tr>
                                             <table id="browse-prodbode-table" class="table table-striped table-condensed" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Sucursal</th>
                                                        <th>Ubicación</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{--Render ubicacion--}}
                                                </tbody>
                                            </table>
                                        @endif
                                    </tbody>
                                </table>
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
                                <label class="control-label">Marca</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->marca_nombre}}
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
                        <h1 class="box-title">Clasificación</h1>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Grupo</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->grupo_nombre }}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Subgrupo</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->subgrupo_nombre }}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Línea</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->linea_nombre}}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4">
                                <label class="control-label">Tipo de producto</label>
                            </div>
                            <div class="col-md-7">
                                {{ $producto->tipoproducto_nombre }}
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
                @if( $producto->producto_maneja_serie && $producto->producto_serie != $producto->producto_referencia )
                  <div class="box box-solid collapsed-box">
                      <div class="box-header">
                          <h1 class="box-title">Informacion de la maquina</h1>
                          <div class="box-tools pull-right">
                              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                          </div>
                      </div>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-4">
                              <label class="control-label">Tercero</label>
                          </div>
                          <div class="col-md-7">
                              {{ $producto->tercero_nit }} - {{ $producto->tercero_nombre }}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                              <label class="control-label">Contacto</label>
                          </div>
                          <div class="col-md-7">
                              {{ $producto->tcontacto_nombre }}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                              <label class="control-label">Servicio</label>
                          </div>
                          <div class="col-md-7">
                              {{ $producto->servicio_nombre }}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                              <label class="control-label">Vencimiento</label>
                          </div>
                          <div class="col-md-7">
                              {{ $producto->producto_vencimiento }}
                          </div>
                        </div>
                        @if( $producto->servicio_nombre != 'DISPONIBLE')
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <a class="btn btn-block edit-info-machine">Editar informacion</a>
                                </div>
                            </div>
                        @endif
                      </div>
                  </div>
                @endif
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

    <section id="producto-content-section">
        <!-- Modal generic producto -->
        <div class="modal fade" id="modal-producto-generic" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header small-box {{ config('koi.template.bg') }}">
                        <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="inner-title-modal modal-title"></h4>
                    </div>
                    {!! Form::open(['id' => 'form-generic-producto', 'data-toggle' => 'validator']) !!}
                    <div class="modal-body">
                        <div class="content-modal">
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm submit-generic">Continuar</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/template" id="edit-machine-tpl">
            <div class="row">
                <label for="producto_tercero" class="col-md-1 control-label">Cliente</label>
                <div class="form-group col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="producto_tercero">
                                <i class="fa fa-user"></i>
                            </button>
                        </span>
                        <input id="producto_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="producto_tercero" type="text" data-contacto="btn-add-contact" maxlength="15"  data-name="tercero_nombre" data-activo="true" value="{{ $producto->tercero_nit }}" required>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="{{ $producto->tercero_nombre }}" readonly required>
                </div>
            </div>
            <div class="row">
                <label for="producto_contacto" class="col-sm-1 control-label">Contacto</label>
                <div class="form-group col-md-3 col-sm-2 col-xs-10">
                    <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button id="btn-add-contact" type="button" class="btn btn-default btn-flat btn-koi-search-contacto-component-table" data-field="producto_contacto" data-name="tcontacto_nombre" data-phone="tcontacto_telefono">
                                <i class="fa fa-address-book"></i>
                            </button>
                        </span>
                        <input id="producto_contacto" name="producto_contacto" type="hidden" value="{{ $producto->producto_contacto }}">
                        <input id="tcontacto_nombre" placeholder="Contacto"  class="form-control" name="tcontacto_nombre" value="{{ $producto->tcontacto_nombre }}" type="text" readonly required>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input id="tcontacto_telefono" class="form-control input-sm" placeholder="Telefono" name="tcontacto_telefono" value="{{ $producto->tcontacto_telefono }}" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask readonly required>
                    </div>
                </div>
            </div>
            <div class="row">
                <label for="producto_servicio" class="col-md-1 control-label">Servicio</label>
                <div class="form-group col-sm-4">
                    <select name="producto_servicio" id="producto_servicio" class="form-control select2-default">
                        @if( $producto->servicio_nombre == '' )
                            @foreach( App\Models\Inventario\Servicio::getServicios() as $key => $value)
                                <option  value="{{ $key }}" {{ $producto->producto_servicio == $key ? 'selected': '' }}>{{ $value }}</option>
                            @endforeach
                        @elseif( $producto->servicio_nombre != 'DISPONIBLE' )
                            @foreach( App\Models\Inventario\Servicio::noDisponible() as $key => $value)
                                <option  value="{{ $key }}" {{ $producto->producto_servicio == $key ? 'selected': '' }}>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <label for="producto_vencimiento" class="col-md-2 control-label">F. Vencimiento</label>
                <div class="form-group col-md-3">
                    <div class="input-group input-group-sm">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" id="producto_vencimiento" name="producto_vencimiento" class="form-control input-sm datepicker" value="{{ $producto->producto_vencimiento }}" required>
                </div>
            </div>
        </script>

        <script type="text/template" id="add-series-producto-tpl">
            <div class="row">
                <label for="producto_nombre" class="col-md-1 control-label">Nombre</label>
                <div class="form-group col-md-8">
                    <input type="text" id="producto_nombre" name="producto_nombre" placeholder="Nombre" value="{{ $producto->producto_nombre }}" class="form-control input-sm input-toupper" maxlength="20" readonly required>
                </div>
            </div>
            <div class="row">
                <label for="producto_referencia" class="col-md-1 control-label">Referencia</label>
                <div class="form-group col-md-6">
                    <input type="text" id="producto_referencia" name="producto_referencia" placeholder="Referencia" value="{{ $producto->producto_referencia }}" class="form-control input-sm input-toupper" maxlength="20" readonly required>
                </div>
            </div>
            <div class="row">
                <label for="producto_serie" class="col-md-1 control-label">Serie</label>
                <div class="form-group col-md-6">
                    <input type="text" id="producto_serie" name="producto_serie" placeholder="Serie" class="form-control input-sm input-toupper" maxlength="20" required>
                </div>
            </div>
        </script>
    </section>
@stop
