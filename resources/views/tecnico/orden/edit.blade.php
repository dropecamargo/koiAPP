@extends('tecnico.orden.main')
@section('breadcrumb')
   <li><a href="{{ route('ordenes.index')}}">Orden</a></li>
    <li><a href="{{ route('ordenes.show', ['ordenes' => $orden->id]) }}">{{ $orden->id}}</a></li>

	<li class="active">Editar</li>
@stop

@section('module')
<div class="box box-whithout-border" id="ordenes-create">
	<div id="render-form-orden">
		{{-- Render form ordenes --}}
	</div>
</div>
@stop