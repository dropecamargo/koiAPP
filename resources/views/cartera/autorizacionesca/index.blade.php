@extends('layout.layout')

@section('title') Autorizaciones @stop

@section('content')
    <section class="content-header">
        <h1>
            Autorizaciones de cartera <small>Administración autorizaciones de cartera</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            <li class="active">Autorizaciones</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary" id="autorizacionesca-main">
            <div class="box-body table-responsive">
                <table id="autorizacionesca-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tercero</th>
                            <th>F.Vencimiento</th>
                            <th>Plazo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@stop
