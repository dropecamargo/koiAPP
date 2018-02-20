@extends('inventario.subgrupo.main')

@section('breadcrumb')
    <li><a href="{{ route('subgrupos.index')}}">Subgrupo</a></li>
    <li class="active">{{ $subgrupo->subgrupo_codigo }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $subgrupo->subgrupo_codigo }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $subgrupo->subgrupo_nombre }}</div>
                </div>
                <div class="form-group col-md-3 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="subgrupo_activo">
                        <input type="checkbox" id="subgrupo_activo" name="subgrupo_activo" value="subgrupo_activo" disabled {{ $subgrupo->subgrupo_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('subgrupos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('subgrupos.edit', ['subgrupo' => $subgrupo->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
