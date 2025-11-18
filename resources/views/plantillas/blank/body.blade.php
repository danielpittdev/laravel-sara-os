<!DOCTYPE html>
<html lang="en" data-theme="light" class="h-full bg-base-100">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ env('APP_NAME') }}</title>

      @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/request-manager.js'])
   </head>

   <body class="max-w-7xl h-full">

      <main class="p-3">
         @yield('contenido')
      </main>

   </body>

</html>
