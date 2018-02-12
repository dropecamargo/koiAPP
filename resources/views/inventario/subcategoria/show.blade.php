@extends('inventario.subcategoria.main')

@section('breadcrumb')
    <li><a href="{{ route('subcategorias.index')}}">Subcategoría</a></li>
    <li class="active">{{ $subcategoria->id }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $subcategoria->subcategoria_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Categoría</label>
                    <div>{{ $subcategoria->categoria_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Nivel 1</label>
                    <div>{{$subcategoria->subcategoria_margen_nivel1}}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Nivel 2</label>
                    <div>{{$subcategoria->subcategoria_margen_nivel2}}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Nivel 3</label>
                    <div>{{$subcategoria->subcategoria_margen_nivel3}}</div>
                </div>
                <div class="form-group col-md-3 col-xs-8 col-sm-3"><br>
                    <label class="checkbox-inline" for="subcategoria_activo">
                        <input type="checkbox" id="subcategoria_activo" name="subcategoria_activo" value="subcategoria_activo" disabled {{ $subcategoria->subcategoria_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('subcategorias.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('subcategorias.edit', ['subcategorias' => $subcategoria->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
