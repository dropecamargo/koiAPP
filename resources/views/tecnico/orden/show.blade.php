@extends('tecnico.orden.main')

@section('module')
    <section class="content-header">
        <h1>
            Ordenes <small>Administración de ordenes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('ordenes.index') }}">Ordenes</a></li>
            <li class="active">{{ $orden->id }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-solid" id="orden-show">
            <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_orden" data-toggle="tab">Orden</a></li>
                    <li><a href="#tab_visitas" data-toggle="tab">Visitas</a></li>
                    <li><a href="#tab_remisiones" data-toggle="tab">Remisiones</a></li>
                    <li><a href="#tab_imagenes" data-toggle="tab">Imagenes</a></li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_orden">
                    <div class="box box-whithout-border">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label class="control-label">Sucursal</label>
                                    <div>{{ $orden->sucursal_nombre }}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">Número</label>
                                    <div>{{ $orden->orden_numero }}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">F.Servcio</label>
                                    <div>{{ $orden->orden_fecha_servicio }}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">H.Servcio</label>
                                    <div>{{ $orden->orden_hora_servicio }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Tercero</label>
                                    <div>
                                        Documento: <a href="{{ route('terceros.show', ['terceros' =>  $orden->orden_tercero ]) }}" target="_blank"> {{ $orden->tercero_nit }} </a>
                                        <br>
                                        Nombre: {{ $orden->tercero_nombre }}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Contacto</label>
                                    <div>
                                        Nombre: {{ $orden->tcontacto_nombre }}
                                        <br>
                                        Telefono: {{ $orden->tcontacto_telefono }}
                                        <br>
                                        Correo: {{ $orden->tcontacto_email }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Producto</label>
                                    <div>
                                        Serie: {{ $orden->producto_serie }}
                                        <br>
                                        Nombre: {{ $orden->producto_nombre }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Tecnico</label>
                                    <div>
                                        Documento: {{ $orden->tecnico_nit }}
                                        <br>
                                        Nombre: {{ $orden->tecnico_nombre }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Daño</label>
                                    <div> {{ $orden->dano_nombre }} </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Solicitante</label>
                                    <div> {{ $orden->solicitante_nombre }} </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Tipo</label>
                                    <div> {{ $orden->tipoorden_nombre }} </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Prioridad</label>
                                    <div> {{ $orden->prioridad_nombre }} </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Sitio</label>
                                    <div> {{ $orden->sitio_nombre }} </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label"> Problema </label>
                                    <div> {{ $orden->orden_problema }} </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label"> Persona </label>
                                    <div> {{ $orden->orden_llamo }} </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="checkbox-inline" for="orden_abierta">
                                        <input type="checkbox" id="orden_abierta" name="orden_abierta" value="orden_abierta" disabled {{ $orden->orden_abierta ? 'checked': '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">      
                            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                                <a href=" {{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_visitas">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="table-responsive no-padding col-md-offset-1 col-md-10">
                                <table id="browse-visitas-list" class="table table-hover table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">N. Visita</th>
                                            <th width="25%">F. Llegada</th>                                                    
                                            <th width="25%">F. Inicio</th>                                                    
                                            <th width="30%">N. Tecnico</th>                                                    
                                            <th width="5%">Info</th>                                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content visita-item --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_remisiones">
                    {{-- Content Remisiones --}}
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="row">
                                <div class="box box-solid">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="box-body table-responsive no-padding">

                                            <table id="browse-orden-remision-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Número</th>
                                                        <th width="50%">Tecnico</th>
                                                        <th width="20%">Sucursal</th>
                                                        <th width="5%">Info</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_imagenes">
                    <div class="box box-solid">
                        <div class="box-body">
                            {{-- Content Images --}}
                            <div id="fine-uploader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop