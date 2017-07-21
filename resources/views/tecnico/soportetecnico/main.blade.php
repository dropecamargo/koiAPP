@extends('layout.layout')
@section('title') Soporte tecnico @stop
@section('content')
   	<section class="content-header">
        <h1>
            Soporte tecnico <small>Administración de soporte tecnico</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
          	<li>Soporte tecnico</li>
        </ol>
    </section>

    <section class="content" id="soportetecnico-main">
        <div class="box box-success">
            <div class="box-body">
            	{!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
	            	<div class="row">
	                    <label for="search_tercero" class="col-md-1 control-label">Tercero</label>
	                    <div class="col-md-2">
	                        <div class="input-group input-group-sm">
	                            <span class="input-group-btn">
	                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="search_tercero">
	                                    <i class="fa fa-user"></i>
	                                </button>
	                            </span>
	                            <input id="search_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="search_tercero" type="text" maxlength="15" data-name="search_tercero_nombre" value="{{ session('search_tercero') }}" required>
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <input id="search_tercero_nombre" name="search_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('search_tercero_nombre') }}" required>
	                    </div>

	               		<label for="search_technical" class="col-md-1 control-label">Tecnico</label>
	                    <div class="col-md-4 text-left">
	                        <select name="search_technical" id="search_technical" class="form-control select2-default-clear change-technical" required>
	                            @foreach( App\Models\Base\Tercero::getTechnicals() as $key => $value)
	                                <option value="{{ $key }}">{{ $value }}</option>
	                            @endforeach
	                        </select>
	                    </div>
	                </div><br>
	                <div class="row">
	                	<div class="col-md-2 col-xs-4 col-md-offset-5">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
	                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="row">
		   	<div class="col-md-8 col-md-offset-2">
		        <div class="box box-solid" id="spinner-calendar">
		        	<div class="box-body">
		                <div id="calendar">
		                    {{-- Render --}}
		                </div>
		            </div>
		        </div>
		   	</div>
        </div>
    </section>
@stop