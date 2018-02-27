@extends('layout.layout')

@section('title') Tipo Pago @stop

@section('content')
    <section class="content-header">
        <h1>
            Tipos de pago <small>Administración tipos de pago</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-tipopago-tpl">
        <div class="row">
            <div class="form-group col-sm-3">
            <label for="tipopago_nombre" class="control-label">Nombre</label>
                <input type="text" id="tipopago_nombre" name="tipopago_nombre" value="<%- tipopago_nombre %>" placeholder="Tipo pago" class="form-control input-sm input-toupper" maxlength="25" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-3">
                <label for="tipopago_documentos" class="control-label">Documento</label>
                <select name="tipopago_documentos" id="tipopago_documentos" class="form-control select2-default">
                    <option value="" selected>Seleccione</option>
                    @foreach( App\Models\Base\Documentos::getDocumentos() as $key => $value)
                        <option value="{{ $key }}" <%- tipopago_documentos == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            </br>
            <div class="form-group col-sm-2 col-xs-8">
                <label class="checkbox-inline" for="tipopago_activo">
                    <input type="checkbox" id="tipopago_activo" name="tipopago_activo" value="tipopago_activo" <%- tipopago_activo ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
    </script>
@stop
