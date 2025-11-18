@extends('plantillas.panel.body')

@section('contenido')
   <div class="fixed top-0 right-0 z-100 pt-20 px-5">
      <div class="alerta mb-5"></div>
   </div>

   <div class="space-y-10 divide-y divide-base-content/20 max-w-xl">
      <div class="space-y-5 pb-10">
         <div class="header">
            <h2 class="font-medium text-md">Datos personales</h2>
            <p class="text-sm text-base-content/50">Edita la información de tus datos personales.</p>
         </div>

         <form id="formulario_usuario" action="{{ route('usuarios.update', ['usuario' => Auth::user()->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="grid xl:grid-cols-6 grid-cols-1 gap-5">
               <!-- Campo -->
               <div class="xl:col-span-2 lg:col-span-3 col-span-1">
                  <label for="text" class="block text-sm/6 font-medium">Nombre</label>
                  <div class="mt-2">
                     <input type="text" name="nombre" value="{{ auth()->user()->nombre }}"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-primary sm:text-sm/6" />
                  </div>
               </div>

               <!-- Campo -->
               <div class="xl:col-span-3 lg:col-span-3 col-span-1">
                  <label for="text" class="block text-sm/6 font-medium">Apellido</label>
                  <div class="mt-2">
                     <input type="text" name="apellido" value="{{ auth()->user()->apellido }}"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-primary sm:text-sm/6" />
                  </div>
               </div>

               <!-- Campo -->
               <div class="xl:col-span-4 lg:col-span-3 col-span-1">
                  <label for="text" class="block text-sm/6 font-medium">Correo electrónico</label>
                  <div class="mt-2">
                     <input type="text" name="email" value="{{ auth()->user()->email }}"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-primary sm:text-sm/6" />
                  </div>
               </div>

               <!-- Campo -->
               <div class="col-span-full mt-5">
                  <div>
                     <button type="submit" class="duration-300 flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Actualizar</button>
                  </div>
               </div>
            </div>
         </form>
      </div>

      <div class="space-y-5 pb-10">
         <div class="header">
            <h2 class="font-medium text-md">Cambiar contraseña</h2>
            <p class="text-sm text-base-content/50">Cambia tu contraseña rápido.</p>
         </div>

         <form id="formulario_cambiar_pass" action="{{ route('usuarios.update', ['usuario' => Auth::user()->id]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="grid xl:grid-cols-6 grid-cols-1 gap-5">
               <!-- Campo -->
               <div class="xl:col-span-3 lg:col-span-3 col-span-1">
                  <label for="text" class="block text-sm/6 font-medium">Contraseña</label>
                  <div class="mt-2">
                     <input type="password" name="current_password"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-primary sm:text-sm/6" />
                  </div>
               </div>

               <!-- Campo -->
               <div class="xl:col-span-4 lg:col-span-3 col-span-1">
                  <label for="text" class="block text-sm/6 font-medium">Nueva contraseña</label>
                  <div class="mt-2">
                     <input type="password" name="password"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-primary sm:text-sm/6" />
                  </div>
               </div>

               <!-- Campo -->
               <div class="xl:col-span-4 lg:col-span-3 col-span-1">
                  <label for="text" class="block text-sm/6 font-medium">Repite nueva contraseña</label>
                  <div class="mt-2">
                     <input type="password" name="password_confirmation"
                        class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-primary sm:text-sm/6" />
                  </div>
               </div>

               <!-- Campo -->
               <div class="col-span-full mt-5">
                  <div>
                     <button type="submit" class="duration-300 flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cambiar contraseña</button>
                  </div>
               </div>
            </div>
         </form>
      </div>

      <div class="space-y-5 pb-10">
         <div class="header">
            <h2 class="font-medium text-md">Suscripción</h2>
            <p class="text-sm text-base-content/50">Gestiona tu suscripción.</p>
         </div>

         @php
            $suscripcionActiva = Auth::user()->suscripcion()->where('stripe_status', 'active')->exists();
         @endphp

         @if ($suscripcionActiva)
            <form id="formulario_cancelar_suscripcion" action="{{ route('api_checkout_sub_eliminar') }}" method="post">
               @csrf

               <!-- Campo -->
               <div class="col-span-full mt-5">
                  <div>
                     <button type="submit" class="duration-300 flex justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Cancelar suscripción</button>
                  </div>
               </div>
            </form>

            <script>
               const formulario_cancelar_suscripcion = document.getElementById('formulario_cancelar_suscripcion');

               formulario_cancelar_suscripcion.addEventListener('submit', (e) => {
                  e.preventDefault();
                  peticion(formulario_cancelar_suscripcion, {
                     reload: true,
                     resetForm: true,
                     highlightInputs: true,
                     showAlert: false
                  });
               });
            </script>
         @else
            <form id="form_sub" action="{{ route('api_checkout_sub') }}">
               <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  Activar suscripción
               </button>
            </form>

            <script>
               const formulario = document.getElementById('form_sub');

               formulario.addEventListener('submit', (e) => {
                  e.preventDefault();
                  peticion(formulario, {
                     resetForm: false,
                     highlightInputs: true,
                     showAlert: false,
                  });
               });
            </script>
         @endif

      </div>
   </div>
@endsection

@section('scripts')
   <script>
      const formulario_usuario = document.getElementById('formulario_usuario');

      formulario_usuario.addEventListener('submit', (e) => {
         e.preventDefault();
         peticion(formulario_usuario, {
            reload: true,
            resetForm: false,
            highlightInputs: true,
            showAlert: false
         });
      });
   </script>

   <script>
      const formulario_cambiar_pass = document.getElementById('formulario_cambiar_pass');

      formulario_cambiar_pass.addEventListener('submit', (e) => {
         e.preventDefault();
         peticion(formulario_cambiar_pass, {
            reload: true,
            resetForm: true,
            highlightInputs: true,
            showAlert: false
         });
      });
   </script>
@endsection
