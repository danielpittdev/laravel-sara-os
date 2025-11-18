@extends('plantillas.auth.fullbody')

@section('contenido')
   <div class="flex min-h-full">
      <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
         <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
               <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="h-10 w-auto" />
               <h2 class="mt-8 text-2xl/9 font-bold tracking-tight">Registrarse</h2>
            </div>

            <div class="mt-10">
               <div>
                  <div class="alerta mb-6"></div>
                  <form action="{{ route('post_registro') }}" id="registro" method="POST" class="space-y-6">
                     @csrf

                     <div class="grid grid-cols-2 gap-5">
                        <div class="lg:col-span-1 col-span-1">
                           <label for="nombre" class="block text-sm/6 font-medium">Nombre</label>
                           <div class="mt-2">
                              <input id="nombre" type="text" name="nombre" autocomplete="given-name"
                                 class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                           </div>
                        </div>

                        <div class="lg:col-span-1 col-span-1">
                           <label for="apellido" class="block text-sm/6 font-medium">Apellido</label>
                           <div class="mt-2">
                              <input id="apellido" type="text" name="apellido" autocomplete="family-name"
                                 class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                           </div>
                        </div>

                        <div class="lg:col-span-2 col-span-1">
                           <label for="email" class="block text-sm/6 font-medium">Correo electrónico</label>
                           <div class="mt-2">
                              <input id="email" type="email" name="email" autocomplete="email"
                                 class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                           </div>
                        </div>

                        <div class="lg:col-span-1 col-span-2">
                           <label for="password" class="block text-sm/6 font-medium">Contraseña</label>
                           <div class="mt-2">
                              <input id="password" type="password" name="password" autocomplete="new-password"
                                 class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                           </div>
                        </div>

                        <div class="lg:col-span-1 col-span-2">
                           <label for="password_confirmation" class="block text-sm/6 font-medium">Repite contraseña</label>
                           <div class="mt-2">
                              <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                                 class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                           </div>
                        </div>
                     </div>

                     <div class="flex items-center justify-between">
                        <div class="text-sm/6">
                           <p class="mt-2 text-sm/6">
                              ¿Eres miembro?
                              <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Iniciar sesión</a>
                           </p>
                        </div>
                     </div>

                     <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Registrarse</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="relative hidden w-0 flex-1 lg:block">
         <video loop muted autoplay class="absolute inset-0 size-full object-cover" src="/video/background.mp4"></video>
      </div>
   </div>
@endsection

@section('scripts')
   <script>
      const loginForm = document.getElementById('registro');

      loginForm.addEventListener('submit', (e) => {
         e.preventDefault();
         peticion(loginForm, {
            resetForm: false,
            highlightInputs: true, // <- resalta los inputs con errores
            showAlert: true
         });
      });
   </script>
@endsection
