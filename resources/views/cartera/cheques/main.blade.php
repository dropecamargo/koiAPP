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

    <section class="content" id="content-show">
        @yield ('module')
        <!-- Modal choise causa -->
        <div class="modal fade" id="modal-causa" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header small-box {{ config('koi.template.bg') }}">
                        <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="inner-title-modal modal-title"></h4>
                    </div>
                    {!! Form::open(['id' => 'form-causal-choise', 'data-toggle' => 'validator']) !!}
                        <div class="modal-body">
                            <div class="content-modal">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-sm">Continuar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
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
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input id="chposfechado1_fecha" name="chposfechado1_fecha" class="form-control input-sm datepicker-back" type="text" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <label for="chposfechado1_central_riesgo" class="control-label col-sm-1">Central de riesgo</label>
                    <div class="form-group col-sm-1">
                        <select name="chposfechado1_central_riesgo" id="chposfechado1_central_riesgo" class="input-sm form-control">
                            <option value="1">SI</option>
                            <option value="0" selected>NO</option>
                        </select>
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
                            <input id="chposfechado1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="chposfechado1_tercero" type="text" maxlength="15" data-concepto="chposfechado2_conceptosrc" data-wrap="detail-chposfechado" data-name="tercero_nombre" value="<%- tercero_nit %>" required>
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
                    <label for="chposfechado1_valor" class="control-label col-sm-1">Valor</label>
                    <div class="form-group col-sm-2">
                        <input type="text" name="chposfechado1_valor" id="chposfechado1_valor" class="form-control input-sm" value="<%- chposfechado1_valor %>" data-currency-price required readonly>
                    </div>
                    <label for="chposfechado1_ch_fecha" class="control-label col-sm-1">Fecha cheque</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="chposfechado1_ch_fecha" id="chposfechado1_ch_fecha" class="form-control input-sm datepicker" value="<%- chposfechado1_ch_fecha %>" required>
                        </div>
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
                    <label for="chposfechado1_girador" class="control-label col-sm-1">Girador</label>
                    <div class="form-group col-sm-4">
                        <input type="text" name="chposfechado1_girador" id="chposfechado1_girador" class=" form-control input-sm input-toupper" placeholder="Nombre" maxlength="100">
                    </div>
                </div>
                <div class="row">
                    <label for="chposfechado1_observaciones" class="col-sm-1 control-label">Observaciones</label>
                    <div class="form-group col-sm-11">
                        <textarea id="chposfechado1_observaciones" name="chposfechado1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('cheques.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-cheque1">{{ trans('app.save') }}</button>
                </div>
            </div>
            <div class="box box-primary" id="detail-chposfechado" hidden>
                <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-chposfechado2" data-toggle="validator">
                    <div class="row">
                        <label for="chposfechado2_conceptosrc" class="control-label col-md-1">Concepto</label>
                        <div class="form-group col-md-3">
                            <select name="chposfechado2_conceptosrc" id="chposfechado2_conceptosrc" class="form-control select2-default change-concepto" data-tercero="chposfechado1_tercero" required>
                                @foreach( App\Models\Cartera\Conceptosrc::getConcepto() as $key => $value)
                                    <option  value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table table id="browse-cheque-list" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th>Concepto</th>
                                <th>Documento</th>
                                <th>Numero</th>
                                <th>Cuota</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Render content chposfechado2 --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4"></th>
                                <th class="text-left">Total</th>
                                <th class="text-right"  id="total">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </script>

@stop
