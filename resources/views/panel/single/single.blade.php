@extends('plantillas.panel.body')

@section('contenido')
   <h1 class="font-medium text-xl">
      Detalles del usuario
   </h1>

   <section class="box p-5">
      <div class="caja">
         <span>{{ $usuario->nombre }} {{ $usuario->apellido }}</span>
      </div>
      <div class="caja">
         <small>{{ $usuario->email }}</small>
      </div>
   </section>

   <section class="space-y-5 grid lg:grid-cols-[auto_1fr] grid-cols-1 items-start gap-3">
      <div class="box w-lg p-5 space-y-5">
         <div class="caja">
            <form action="{{ route('usuarios.update', ['usuario' => $usuario->id]) }}" method="post" class="space-y-5" id="formulario">
               @method('PUT')
               <div class="grid lg:grid-cols-2 grid-cols-1 gap-3">

                  <!-- Input -->
                  <div class="campo lg:col-span-1 col-span-1">
                     <label for="nombre" class="block text-sm/6 font-medium text-base-content">Nombre</label>
                     <div class="mt-2">
                        <input value="{{ $usuario->nombre }}" id="nombre" type="text" name="nombre"
                           class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                     </div>
                  </div>

                  <!-- Input -->
                  <div class="campo lg:col-span-1 col-span-1">
                     <label for="apellido" class="block text-sm/6 font-medium text-base-content">Apellido</label>
                     <div class="mt-2">
                        <input value="{{ $usuario->apellido }}" id="apellido" type="text" name="apellido"
                           class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                     </div>
                  </div>

                  <!-- Input -->
                  <div class="campo lg:col-span-2 col-span-1">
                     <label for="email" class="block text-sm/6 font-medium text-base-content">Correo electrónico</label>
                     <div class="mt-2">
                        <input value="{{ $usuario->email }}" id="email" type="email" name="email"
                           class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                     </div>
                  </div>

                  <!-- Botón enviar -->
                  <div class="col-span-2 mt-5">
                     <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Guardar
                     </button>
                  </div>

               </div>
            </form>

            <!-- JS -->
            <script>
               const formulario = document.getElementById('formulario');

               formulario.addEventListener('submit', (e) => {
                  e.preventDefault();
                  peticion(formulario, {
                     resetForm: false,
                     highlightInputs: true,
                     showAlert: false,
                     reload: true
                  });
               });
            </script>
         </div>
      </div>
   </section>
@endsection
