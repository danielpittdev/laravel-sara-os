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

      <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-base-100 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
         <button type="button" command="show-modal" commandfor="sidebar" class="-m-2.5 p-2.5 text-gray-400 hover:text-base-content/50 lg:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
               <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
         </button>
         <a href="{{ route('panel_ajustes') }}" class="ml-auto">
            <span class="sr-only">Your profile</span>
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
         </a>
      </div>

      <main class="py-10 lg:pl-72">
         <div class="px-4 sm:px-6 lg:px-8 space-y-7">
            @yield('header')
            @yield('contenido')
         </div>
      </main>

      @yield('extras')
      @yield('scripts')

   </body>

</html>
