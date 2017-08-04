@extends('layout.layout')

@section('title') Sitios de atención @stop

@section('content')
    <section class="content-header">
        <h1>
            Sitios de atención <small>Administración sitios de atención</small>
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
