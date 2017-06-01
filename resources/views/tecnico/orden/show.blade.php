@extends('tecnico.orden.main')

@section('breadcrumb')
    <li class="active">Ordenes</li>
@stop

@section('module')
<div class="box box-solid">
    <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_orden" data-toggle="tab">Orden</a></li>
            <li><a href="#tab_visitas" data-toggle="tab">Visitas</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane active" id="tab_orden">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Código</label>
                        <div>{{ $orden->id }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Tercero</label>
                        <div>
                            Documento: <a href="{{ route('terceros.show', ['terceros' =>  $orden->orden_tercero ]) }}" title="Ver tercero">{{$orden->tercero_nit}}</a>
                            <br>
                            Nombre: {{ $orden->tercero_nombre }}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="form-group col-md-3">
                		<label class="control-label">Fecha</label>
                		<div>{{ $orden->orden_fecha }}</div>
                	</div>

                	<div class="form-group col-md-3">
                		<label class="control-label">Daño</label>
                		<div>{{ $orden->dano_nombre }}</div>
                	</div>
                </div>
                <div class="row">
                	<div class="form-group col-md-3">
                		<label class="control-label">Tipo</label>
                		<div>{{ $orden->tipoorden_nombre }}</div>
                	</div>

                	<div class="form-group col-md-3">
                		<label class="control-label">Prioridad</label>
                		<div>{{ $orden->prioridad_nombre }}</div>
                	</div>
                </div>
                <div class="row">
                	<div class="form-group col-md-3">
                		<label class="control-label">Solicitante</label>
                		<div>{{ $orden->solicitante_nombre }}</div>
                	</div>
                </div>
                <div class="row">
                	<div class="col-md-3">
                		<label class="control-label"> Problema </label>
                		<div>{{ $orden->orden_problema }}</div>
                	</div>
                    <div class="form-group col-md-3">
                        <label class="checkbox-inline" for="orden_abierta">
                            <input type="checkbox" id="orden_abierta" name="orden_abierta" value="orden_abierta" disabled {{ $orden->orden_abierta ? 'checked': '' }}> Activo
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_visitas">
            <div class="box box-solid">
                 <div class="box-body table-responsive no-padding col-md-offset-1 col-md-10">
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

    <div class="box-footer with-border">
        <div class="row">
            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                <a href=" {{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6">
                <a href=" {{ route('ordenes.edit', ['ordenes' => $orden->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
            </div>
        </div>
    </div>   
</div>
@stop