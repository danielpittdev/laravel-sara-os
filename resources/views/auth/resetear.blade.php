@extends('plantillas.auth.fullbody')

@section('contenido')
   <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
         <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="mx-auto h-10 w-auto" />
         <h2 class="mt-6 text-center text-2xl/9 font-bold tracking-tight">Recuperar contraseña</h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
         <form id="resetear" action="{{ route('post_resetear') }}" method="POST" class="space-y-6 max-w-sm mx-auto">
            @csrf
            <div class="alerta mb-6"></div>

            <div class="hidden">
               <div class="mt-2">
                  <input id="token" type="text" name="token" value="{{ $id }}"
                     class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
               </div>
            </div>

            <div>
               <label for="email" class="block text-sm/6 font-medium">Correo electrónico</label>
               <div class="mt-2">
                  <input id="email" type="text" name="email"
                     class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
               </div>
            </div>

            <div>
               <label for="password" class="block text-sm/6 font-medium">Contraseña</label>
               <div class="mt-2">
                  <input id="password" type="password" name="password"
                     class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
               </div>
            </div>

            <div>
               <label for="password_confirmation" class="block text-sm/6 font-medium">Repite contraseña</label>
               <div class="mt-2">
                  <input id="password_confirmation" type="password" name="password_confirmation"
                     class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
               </div>
            </div>

            <div class="mt-10">
               <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Recuperar contraseña</button>
            </div>
         </form>
      </div>
   </div>
@endsection

@section('scripts')
   <script>
      const loginForm = document.getElementById('resetear');

      loginForm.addEventListener('submit', (e) => {
         e.preventDefault();
         peticion(loginForm, {
            resetForm: false,
            highlightInputs: true,
            showAlert: true
         });
      });
   </script>
@endsection
