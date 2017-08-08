@extends('inventario.unidadesnegocio.main')

@section('breadcrumb')
    <li><a href="{{ route('unidadesnegocio.index')}}">Unidad de negocio</a></li>
    <li class="active">{{ $unidadnegocio->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $unidadnegocio->unidadnegocio_nombre }}</div>
                </div>
                <br>
                <div class="form-group col-md-1">
                    <label class="checkbox-inline" for="unidadnegocio_activo">
                    <input type="checkbox" id="unidadnegocio_activo" name="unidadnegocio_activo" value="unidadnegocio_activo" disabled {{ $unidadnegocio->unidadnegocio_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('unidadesnegocio.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('unidadesnegocio.edit', ['unidades' => $unidadnegocio->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
