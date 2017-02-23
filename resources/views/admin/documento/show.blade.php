@extends('admin.documento.main')

@section('breadcrumb')
<li><a href="{{route('documento.index')}}">Documentos</a></li>
<li class="active">{{ $documentos->documentos_codigo }}</li>
@stop

@section('module')
<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label">Id</label>
                <div>{{ $documentos->id }}</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label class="control-label">Código</label>
                <div>{{ $documentos->documentos_codigo }}</div>
            </div>
            <div class="form-group col-md-9">
                <label class="control-label">Nombre</label>
                <div>{{ $documentos->documentos_nombre }}</div>
            </div>
        </div>        
    </div>
    
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                <a href=" {{ route('documento.index')}} " class="btn btn-default btn-sm btn-block"> {{ trans('app.comeback') }}</a>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                <a href=" {{ route('documento.edit', ['documentos' => $documentos->id])}}" class="btn btn-primary btn-sm btn-block">{{trans('app.edit')}}</a>
            </div>
        </div>
    </div>
</div>
@stop
