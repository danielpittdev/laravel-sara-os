<div class="footer">
   @if (isset($footerMessage))
      <p>{{ $footerMessage }}</p>
   @else
      <p>Este es un correo electrónico automático, por favor no responder.</p>
   @endif

   <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>

   @if (isset($unsubscribeUrl))
      <p><a href="{{ $unsubscribeUrl }}" style="color: #777; text-decoration: underline;">Darse de baja</a></p>
   @endif

   @if (isset($contactEmail))
      <p>Para soporte contacta: <a href="mailto:{{ $contactEmail }}" style="color: #777;">{{ $contactEmail }}</a></p>
   @endif
</div>
