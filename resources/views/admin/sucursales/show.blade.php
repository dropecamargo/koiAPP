@extends('admin.sucursales.main')

@section('breadcrumb')
    <li><a href="{{ route('sucursales.index')}}">Sucursal</a></li>
    <li class="active">{{ $sucursal->id  }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $sucursal->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-5">
                    <label class="control-label">Direccion</label> <small> {{ $sucursal->sucursal_direccion_nomenclatura }}</small>
                    <div>{{ $sucursal->sucursal_direccion }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Regional</label>
                    <div>{{ $sucursal->regional_nombre }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Teléfono</label>
                    <div>{{ $sucursal->sucursal_telefono }}</div>
                </div>
                <div class="form-group col-md-4"><br>
                    <label class="" for="sucursal_activo">
                    <input type="checkbox" id="sucursal_activo" name="sucursal_activo" value="sucursal_activo" disabled {{ $sucursal->sucursal_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>

        </div>

        <div class="box-footer with-border">
            <div class="row">
                @if( $sucursal->sucursal_nombre != '090 GARANTIAS' && $sucursal->sucursal_nombre != '091 PROVISIONAL')
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                @else
                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                @endif
                    <a href=" {{ route('sucursales.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>

                @if( $sucursal->sucursal_nombre != '090 GARANTIAS' && $sucursal->sucursal_nombre != '091 PROVISIONAL')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('sucursales.edit', ['sucursales' => $sucursal->id ])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
