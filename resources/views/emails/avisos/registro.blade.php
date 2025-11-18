@extends('emails.layouts.base')

@section('title', '¡Bienvenido!')

@section('email-title', '¡Bienvenido!')

@section('content')
   <p>Hola {{ $user->nombre }},</p>

   <p>
      Gracias por registrarte en {{ env('APP_NAME') }}, esperemos que te guste mucho! :)
   </p>

   <p>Saludos cordiales,<br>
      El equipo de {{ config('app.name') }}</p>
@endsection
