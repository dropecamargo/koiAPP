@extends('layout.layout')

@section('title') Anticipos @stop

@section('content')
    <section class="content-header">
        <h1>
            Anticipos <small>Administración de anticipos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>
    <script type="text/template" id="add-anticipos-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-anticipo1" data-toggle="validator">
                <div class="row">
                    <label for="anticipo1_sucursal" class="col-sm-1 col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-2">
                        <select name="anticipo1_sucursal" id="anticipo1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-wrapper="anticipo-create" data-field="anticipo1_numero" data-document ="anticipo">
                            @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- anticipo1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="anticipo1_numero" class="col-sm-1 col-md-1 control-label">Número</label>
                    <div class="form-group col-sm-1 col-md-1">     
                        <input id="anticipo1_numero" name="anticipo1_numero" class="form-control input-sm" type="number" min="1" value="<%- anticipo1_numero %>" required readonly>
                    </div>
                    <label for="anticipo1_fecha" class="col-sm-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">     
                        <input id="anticipo1_fecha" name="anticipo1_fecha" class="form-control input-sm datepicker" type="text" value="<%- anticipo1_fecha %>" required>
                    </div>
                </div>
                <div class="row">
                     <label for="anticipo1_tercero" class="col-md-1 control-label">Cliente</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="anticipo1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="anticipo1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="anticipo1_tercero" type="text" maxlength="15" data-wrapper="anticipo-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-10">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_cuentas" class="col-md-1 control-label">Cuenta Banco</label>
                    <div class="form-group col-md-3">
                        <select name="anticipo1_cuentas" id="anticipo1_cuentas" class="form-control select2-default" required>
                           @foreach( App\Models\Cartera\CuentaBanco::getCuenta() as $key => $value)
                                <option  value="{{ $key }}" <%- anticipo1_cuentas == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="anticipo1_valor" class="col-md-1 control-label">Valor</label>
                    <div class="form-group col-md-2">
                        <input type="text" name="anticipo1_valor" id="anticipo1_valor" class="input-sm form-control" data-currency required>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_vendedor" class="col-sm-1 col-md-1 control-label">Vendedor</label>
                    <div class="form-group col-sm-4">
                        <select name="anticipo1_vendedor" id="anticipo1_vendedor" class="form-control select2-default">
                            @foreach( App\Models\Base\Tercero::getSellers() as $key => $value)
                            <option  value="{{ $key }}" <%- anticipo1_vendedor == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="anticipo1_observacion" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-sm-11">
                    <textarea id="anticipo1_observacion" name="anticipo1_observacion" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('anticipos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-anticipo1">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>
    </script>
@stop 