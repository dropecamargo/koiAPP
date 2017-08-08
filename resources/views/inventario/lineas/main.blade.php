@extends('layout.layout')

@section('title') Líneas de inventario @stop

@section('content')
    <section class="content-header">
        <h1>
            Líneas de inventario <small>Administración líneas de inventario</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>
@stop
