@extends('emails.layouts.comunicativo')

@section('title', $datos['asunto'])

@section('email-title', $datos['asunto'])

@section('content')
   <p>
      {{ $datos['cuerpo'] }}
   </p>
@endsection
