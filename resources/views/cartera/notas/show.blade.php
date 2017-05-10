@extends('cartera.notas.main')

@section('breadcrumb')
    <li><a href="{{ route('notas.index')}}">Nota</a></li>
    <li class="active">{{ $nota->id }}</li>
@stop

@section('module')
    <div class="box box-success" id="nota-show">
        <div class="box-body">
            
        </div>
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-offset-5 col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('notas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop