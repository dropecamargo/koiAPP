@extends('tesoreria.cajasmenores.main')

@section('breadcrumb')
    <li class="active">Caja Menor</li>
@stop

@section('module')
	<div id="cajasmenores-main">
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-ajuste-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="form-group">
                        <label for="searchcajamenor_tercero" class="col-md-1 control-label">Tercero</label>
                        <div class="col-md-3">
                            <input id="searchcajamenor_tercero" type="text" name="searchcajamenor_tercero" class="form-control" value = "{{ session('searchcajamenor_tercero') }}" placeholder="Nit Tercero">
                        </div>
                        <label for="searchcajamenor_regional" class="col-md-1 control-label">Regional</label>
                        <div class="col-md-4">
                            <select id="searchcajamenor_regional"  class="form-control select2-default-clear" name="searchcajamenor_regional">
                                @foreach( App\Models\Base\Regional::getRegionales() as $key => $value)
                                <option  value="{{ $key }}" {{ session('searchcajamenor_regional') == $key ? 'selected': '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="searchcajamenor_numero" class="col-md-1 control-label">Número</label>
                        <div class="col-md-2">
                            <input id="searchcajamenor_numero" type="text" name="searchcajamenor_numero" class="form-control" value = "{{ session('searchcajamenor_numero') }}" placeholder="Número caja menor">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-2 col-xs-4">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <a href="{{ route('cajasmenores.create') }}" class="btn btn-default btn-block btn-sm">
                                <i class="fa fa-plus"></i> Nueva caja menor
                            </a>
                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="table-responsive">
                    <table id="cajasmenores-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th width="25%">Regional</th>
                                <th width="40%">Tercero</th>
                                <th width="25%">Cuenta banco</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
