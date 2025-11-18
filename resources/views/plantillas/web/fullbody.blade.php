<!DOCTYPE html>
<html lang="en" data-theme="light" class="h-full bg-base-200">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ env('APP_NAME') }}</title>

      @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/request-manager.js'])
   </head>

   <body class="h-full">

      <main class="h-full">
         @include('plantillas.web.fragmentos.header')
         @yield('contenido')
      </main>

   </body>

</html>
