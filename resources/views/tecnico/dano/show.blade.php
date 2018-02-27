@extends('tecnico.dano.main')

@section('breadcrumb')
    <li><a href="{{ route('danos.index')}}">Daño</a></li>
    <li class="active">{{ $dano->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-8">
                    <label>Nombre</label>
                    <div>{{ $dano->dano_nombre }}</div>
                </div>
                <div class="col-sm-2 col-xs-8"><br>
                    <label class="checkbox-inline" for="dano_activo">
                        <input type="checkbox" id="dano_activo" name="dano_activo" value="dano_activo" disabled {{ $dano->dano_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('danos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('danos.edit', ['danos' => $dano->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
