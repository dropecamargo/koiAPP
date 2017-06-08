@extends('layout.layout')

@section('title') Cheques @stop

@section('content')
    <section class="content-header">
        <h1>
            Cheques <small>Administración de cheques pos-fechados</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-cheques-tpl">
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-cheque1" data-toggle="validator">
                <div class="row">
                    <label for="chposfechado1_sucursal" class="col-sm-1 col-md-1 control-label">Sucursal</label>
                    <div class="form-group col-sm-2">
                        <select name="chposfechado1_sucursal" id="chposfechado1_sucursal" class="form-control select2-default change-sucursal-consecutive-koi-component" data-wrapper="cheque-create" data-field="chposfechado1_numero" data-document ="chequepos">
                            @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                            <option  value="{{ $key }}" <%- chposfechado1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="chposfechado1_numero" class="col-sm-1 col-md-1 control-label">Número</label>
                    <div class="form-group col-sm-1 col-md-1">     
                        <input id="chposfechado1_numero" name="chposfechado1_numero" class="form-control input-sm" type="number" min="1" value="<%- chposfechado1_numero %>" required readonly>
                    </div>
                    <label for="chposfechado1_fecha" class="col-sm-1 control-label">Fecha</label>
                    <div class="form-group col-sm-2">     
                        <input id="chposfechado1_fecha" name="chposfechado1_fecha" class="form-control input-sm datepicker" type="text" value="<%- chposfechado1_fecha %>" required>
                    </div>
                </div>
                <div class="row">
                    <label for="chposfechado1_tercero" class="col-md-1 control-label">Cliente</label>
                    <div class="form-group col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="chposfechado1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="chposfechado1_tercero" placeholder="Cliente" class="form-control tercero-koi-component aaa" name="chposfechado1_tercero" type="text" maxlength="15" data-wrapper="anticipo-create" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-10">
                        <input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <label for="chposfechado1_ch_numero" class="control-label col-sm-1">N° cheque</label>
                    <div class="form-group col-sm-2">
                        <input type="text" name="chposfechado1_ch_numero" id="chposfechado1_ch_numero" class="form-control input-sm input-toupper" placeholder="Número cheque" required>
                    </div>
                    <label for="" class="control-label col-sm-1">Fecha cheque</label>
                    <div class="form-group col-sm-2">
                        <input type="text" name="chposfechado1_ch_fecha" id="chposfechado1_ch_fecha" class="form-control input-sm datepicker" value="<%- chposfechado1_ch_fecha %>" required>
                    </div>
                </div>
                <div class="row">
                    <label for="chposfechado1_banco" class="control-label col-sm-1">Banco</label>
                    <div class="form-group col-sm-3">
                        <select name="chposfechado1_banco" id="chposfechado1_banco" class="form-control select2-default" required>
                            @foreach( App\Models\Cartera\Banco::getBancos() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="chposfechado1_observaciones" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-sm-11">
                        <textarea id="chposfechado1_observaciones" name="chposfechado1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                </div>    
            </form>
        </div>
    </script>
@stop