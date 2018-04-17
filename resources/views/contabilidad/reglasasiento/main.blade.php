@extends('layout.layout')

@section('title') Reglas asientos @stop

@section('content')
<section class="content-header">
    <h1>
        Reglas asientos <small>Configuración reglas asientos</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
        <li class="active">Configuración reglas asientos</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <label for="regla_asiento_documento" class="col-sm-1 control-label">Documento</label>
            <div class="form-group col-sm-3">
                <select name="regla_asiento_documento" id="regla_asiento_documento" class="form-control select2-default" required>
                    <option value="" selected>Seleccione</option>
                    @foreach( App\Models\Contabilidad\Documento::getDocuments() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</section>
@stop
