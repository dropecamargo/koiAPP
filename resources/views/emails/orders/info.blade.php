@extends('emails.layout')

@section('content')
    <p>Orden:<strong>{!!$orden->id!!}</strong></p>
    <p>Tercero:<strong>{!!$orden->tercero_nombre!!}</strong></p>
@stop