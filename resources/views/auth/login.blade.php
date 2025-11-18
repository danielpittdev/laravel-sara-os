@extends('plantillas.auth.fullbody')

@section('contenido')
   <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
         <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="mx-auto h-10 w-auto" />
         <h2 class="mt-6 text-center text-2xl/9 font-bold tracking-tight">Iniciar sesión</h2>
      </div>

      <div class="mt-0 sm:mx-auto sm:w-full sm:max-w-[480px]">

         <form id="login" action="/api/auth/login" method="post" class="max-w-sm mx-auto">
            @csrf

            <div class="text-sm border p-4 rounded-md alerta duration-500"></div>

            <div class="space-y-6 mt-2">
               <div>
                  <label for="email" class="block text-sm/6 font-medium">Correo electrónico</label>
                  <div class="mt-2">
                     <input id="email" type="text" name="email" autocomplete="email"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                  </div>
               </div>

               <div>
                  <label for="password" class="block text-sm/6 font-medium">Contraseña</label>
                  <div class="mt-2">
                     <input id="password" type="password" name="password" autocomplete="current-password"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                  </div>
               </div>

               <div class="flex items-center justify-between">
                  <div class="text-sm/6">
                     <a href="{{ route('recuperar') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">¿Olvidó la contraseña?</a>
                  </div>
               </div>

               <div>
                  <button type="submit" class="duration-300 flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Iniciar sesión</button>
               </div>
            </div>
         </form>

         <p class="mt-10 text-center text-sm/6">
            ¿No estás registrado?
            <a href="{{ route('registro') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Registrate ahora</a>
         </p>
      </div>
   </div>
@endsection

@section('scripts')
   <script>
      const loginForm = document.getElementById('login');

      loginForm.addEventListener('submit', (e) => {
         e.preventDefault();
         peticion(loginForm, {
            resetForm: true,
            highlightInputs: true,
            showAlert: false
         });
      });
   </script>
@endsection
