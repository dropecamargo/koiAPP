@extends('layout.layout')

@section('title') Ubicaciones @stop

@section('content')
    <section class="content-header">
        <h1>
            Ubicaciones <small>Administración de ubicaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    {{--template Ubicacion--}}
    <script type="text/template" id="add-ubicacion-tpl">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="ubicacion_nombre" class="control-label">Nombre</label>
                <input type="text" id="ubicacion_nombre" name="ubicacion_nombre" value="<%- ubicacion_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="25" required>
            </div><br>
            <div class="form-group col-md-2">
                <label class="checkbox-inline" for="ubicacion_activo">
                    <input type="checkbox" id="ubicacion_activo" name="ubicacion_activo" value="ubicacion_activo" <%- parseInt(ubicacion_activo) ? 'checked': ''%>> Activo
                </label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="ubicacion_sucursal" class="control-label">Sucursal</label>
                <select name="ubicacion_sucursal" id="ubicacion_sucursal" class="form-control select2-default-clear" required >
                    @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                        <option value="{{ $key }}" <%- ubicacion_sucursal == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </script>
@stop