@extends('layout.layout')

@section('title') Gestión carteras @stop

@section('content')
    <section class="content-header">
        <h1>
            Gestión carteras <small>Administración gestión de cartera</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            <li class="active">Gestión de carteras</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary" id="gestioncarteras-main">
            <div class="box-body">
                {!! Form::open(['id' => 'form-gestioncarteras', 'data-toggle' => 'validator', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="form-group col-md-3 col-md-offset-1">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchgestioncartera_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="searchgestioncartera_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchgestioncartera_tercero" type="text" maxlength="15" data-name="searchgestioncartera_tercero_nombre" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-6">
                            <input id="searchgestioncartera_tercero_nombre" name="searchgestioncartera_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">
                			<div class="input-group">
                				<label class="input-group-btn">
                					<span class="btn btn-primary btn-sm">
                						Examinar... <input type="file" id="file" name="file" class="selectfile">
                					</span>
                				</label>
                				<input type="text" class="form-control input-sm" readonly>
                			</div>
                			<span class="help-block">
                				Por favor, seleccione un archivo a importar
                			</span>
                		</div>
                        <div class="col-md-2 col-md-offset-1 col-sm-6 col-xs-6 text-left">
                            <button type="button" class="btn btn-success btn-sm btn-block submit-import">
                                <i class="fa fa-upload"></i> {{ trans('app.import.xls') }}
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop
