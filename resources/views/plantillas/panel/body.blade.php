<!DOCTYPE html>
<html lang="en" data-theme="light" class="h-full bg-base-200/70">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ env('APP_NAME') }}</title>

      @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/request-manager.js'])
   </head>

   <body class="h-full">

      <!-- Aside -->
      @include('plantillas.panel.fragmentos.aside')

      <main class="py-10 lg:pl-72">
         <div class="max-w-7xl px-4 sm:px-6 lg:px-8 space-y-7">
            @yield('header')
            @yield('contenido')
         </div>
      </main>

      @yield('extras')
      @yield('scripts')

   </body>

</html>
