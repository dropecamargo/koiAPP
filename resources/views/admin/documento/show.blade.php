@extends('admin.documento.main')

@section('breadcrumb')
    <li><a href="{{route('documento.index')}}">Documento</a></li>
    <li class="active">{{ $documentos->documentos_codigo }}</li>
@stop

@section('module')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label class="control-label">Código</label>
                    <div>{{ $documentos->documentos_codigo }}</div>
                </div>
                <div class="form-group col-sm-9">
                    <label class="control-label">Nombre</label>
                    <div>{{ $documentos->documentos_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label class="control-label">Tipo</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <input type="checkbox" id="documentos_cartera" name="documentos_cartera" value="documentos_cartera" disabled {{ $documentos->documentos_cartera ? 'checked': '' }}> Cartera
                </div>
                <div class="col-sm-2">
                    <input type="checkbox" id="documentos_contabilidad" name="documentos_contabilidad" value="documentos_contabilidad" disabled {{ $documentos->documentos_contabilidad ? 'checked': '' }}> Contabilidad
                </div>
                <div class="col-sm-2">
                    <input type="checkbox" id="documentos_comercial" name="documentos_comercial" value="documentos_comercial" disabled {{ $documentos->documentos_comercial ? 'checked': '' }}> Comercial
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <input type="checkbox" id="documentos_inventario" name="documentos_inventario" value="documentos_inventario" disabled {{ $documentos->documentos_inventario ? 'checked': '' }}> Inventario
                </div>
                <div class="col-sm-2">
                    <input type="checkbox" id="documentos_tecnico" name="documentos_tecnico" value="documentos_tecnico" disabled {{ $documentos->documentos_tecnico ? 'checked': '' }}> Técnico
                </div>
                <div class="col-sm-2">
                    <input type="checkbox" id="documentos_tesoreria" name="documentos_tesoreria" value="documentos_tesoreria" disabled {{ $documentos->documentos_tesoreria ? 'checked': '' }}> Tesorería
                </div>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-sm-2 col-sm-offset-4 col-xs-6 text-left">
                    <a href=" {{ route('documento.index')}} " class="btn btn-default btn-sm btn-block"> {{ trans('app.comeback') }}</a>
                </div>
                <div class="col-sm-2 col-xs-6 text-right">
                    <a href=" {{ route('documento.edit', ['documentos' => $documentos->id])}}" class="btn btn-primary btn-sm btn-block">{{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
