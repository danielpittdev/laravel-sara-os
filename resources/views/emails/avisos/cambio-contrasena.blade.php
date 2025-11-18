@extends('emails.layouts.base')

@section('title', 'Cambio de contraseña')

@section('email-title', 'Cambio de contraseña')

@section('content')
   <p>Hola {{ $user->nombre }},</p>

   <p>
      La contraseña de tu cuenta ha sido cambiada. Hoy {{ Carbon\Carbon::now()->translatedFormat('d M l \a \l\a\s H:i\h') }}.
   </p>

   <p>Si no has sido tú por favor ponte en contacto con nosotros de manera inmediata. Si has sido tú no te preocupes, puedes ignorar este mensaje.</p>

   <p>Saludos cordiales,<br>
      El equipo de {{ config('app.name') }}</p>
@endsection
