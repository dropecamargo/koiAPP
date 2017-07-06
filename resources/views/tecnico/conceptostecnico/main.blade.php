@extends('layout.layout')

@section('title') Concepto tecnico @stop

@section('content')
    <section class="content-header">
        <h1>
            Concepto tecnico <small>Administración de concepto tecnico</small>
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