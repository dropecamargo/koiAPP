@extends('cartera.autorizacionesca.main')

@section('breadcrumb')
    <li><a href="{{ route('autorizacionesca.index')}}">Autorizaciones</a></li>
    <li class="active">{{ $autorizaca->id }}</li>
@stop

@section('module')

@stop