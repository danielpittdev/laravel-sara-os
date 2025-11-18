<div class="header">
   @if (isset($logo))
      <img src="{{ $logo }}" alt="{{ config('app.name') }}" style="max-height: 60px; margin-bottom: 10px;">
   @endif

   <h1>@yield('email-title', 'Notificación')</h1>

   @if (isset($subtitle))
      <p style="margin: 10px 0 0 0; color: #777; font-size: 14px;">{{ $subtitle }}</p>
   @endif
</div>
