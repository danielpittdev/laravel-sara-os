@extends('plantillas.panel.body')

@section('header')
   <!-- Header -->
   <div class="header flex justify-between items-center">
      <h1 class="font-medium text-lg">Usuarios</h1>

      <div class="sec">

         <el-dropdown class="inline-block">
            <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-base-100 px-3 py-2 text-sm font-semibold text-base-content shadow-xs inset-ring-1 inset-ring-gray-300 hover:bg-base-200">
               Opciones
               <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
                  <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
               </svg>
            </button>

            <el-menu anchor="bottom end" popover
               class="w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-base-100 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">

               <div class="p-1">
                  <button command="show-modal" commandfor="drawer" href="#" class="w-full group/item flex items-center px-4 py-2 text-sm text-base-content/70 focus:bg-base-200 focus:text-base-content focus:outline-hidden">
                     <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="mr-3 size-5 text-gray-400 group-focus/item:text-gray-500">
                        <path
                           d="M10 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM1.615 16.428a1.224 1.224 0 0 1-.569-1.175 6.002 6.002 0 0 1 11.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 0 1 7 18a9.953 9.953 0 0 1-5.385-1.572ZM16.25 5.75a.75.75 0 0 0-1.5 0v2h-2a.75.75 0 0 0 0 1.5h2v2a.75.75 0 0 0 1.5 0v-2h2a.75.75 0 0 0 0-1.5h-2v-2Z" />
                     </svg>
                     Crear usuario
                  </button>
               </div>
            </el-menu>
         </el-dropdown>

      </div>
   </div>
@endsection

@section('contenido')
   <div class="overflow-x-auto rounded-box border border-base-content/10 bg-base-100">

      <table class="table">
         <!-- head -->
         <thead>
            <tr>
               <th></th>
               <th>Nombre</th>
               <th>Email</th>
               <th>ID</th>
            </tr>
         </thead>
         <tbody>
            @php
               $usuarios = DB::table('usuarios')
                   ->where('id', '!=', auth('web')->user()->id)
                   ->get();
            @endphp
            <!-- row 1 -->
            @foreach ($usuarios as $usuario)
               <tr>
                  <th>1</th>
                  <td>
                     <a class="text-blue-500 hover:underline" href="{{ route('single_usuario', ['id' => $usuario->id]) }}">
                        {{ $usuario->nombre . ' ' . $usuario->apellido }}
                     </a>
                  </td>
                  <td>{{ $usuario->email }}</td>
                  <td>{{ $usuario->id }}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
@endsection

@section('extras')
   <el-dialog>
      <dialog id="drawer" aria-labelledby="drawer-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-hidden bg-transparent backdrop:bg-transparent">
         <el-dialog-backdrop class="absolute inset-0 bg-base-300/50 transition-opacity duration-500 ease-in-out data-closed:opacity-0"></el-dialog-backdrop>

         <div tabindex="0" class="absolute inset-0 pl-10 focus:outline-none sm:pl-16">
            <el-dialog-panel class="ml-auto block size-full max-w-md transform transition duration-500 ease-in-out data-closed:translate-x-full">
               <form id="registrar_usuario" action="{{ route('post_registro') }}" class="relative flex h-full flex-col divide-y divide-base-content/20 bg-base-100 shadow-xl" method="post">
                  @csrf
                  <div class="h-0 flex-1 overflow-y-auto">
                     <div class="bg-primary px-4 py-6 sm:px-6">
                        <div class="flex items-center justify-between">
                           <h2 id="drawer-title" class="text-base font-semibold text-white">Nuevo usuario</h2>
                           <div class="ml-3 flex h-7 items-center">
                              <button type="button" command="close" commandfor="drawer" class="relative rounded-md text-base-300 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                 <span class="absolute -inset-2.5"></span>
                                 <span class="sr-only">Close panel</span>
                                 <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                 </svg>
                              </button>
                           </div>
                        </div>
                        <div class="mt-1">
                           <p class="text-sm text-primary-content">Crea un nuevo usuario para el sistema de manera mucho más rápida.</p>
                        </div>
                     </div>
                     <div class="flex flex-1 flex-col justify-between">
                        <div class="divide-y divide-gray-200 px-4 sm:px-6">
                           <div class="space-y-6 pt-6 pb-5">

                              <div class="grid grid-cols-2 gap-4">
                                 <div class="lg:col-span-1 col-span-2">
                                    <label for="nombre" class="block text-sm/6 font-medium">Nombre</label>
                                    <div class="mt-2">
                                       <input id="nombre" type="text" name="nombre"
                                          class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                 </div>
                                 <div class="lg:col-span-1 col-span-2">
                                    <label for="apellido" class="block text-sm/6 font-medium">Apellido</label>
                                    <div class="mt-2">
                                       <input id="apellido" type="text" name="apellido"
                                          class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                 </div>
                                 <div class="lg:col-span-2 col-span-2">
                                    <label for="email" class="block text-sm/6 font-medium">Email</label>
                                    <div class="mt-2">
                                       <input id="email" type="text" name="email"
                                          class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                 </div>
                                 <div class="lg:col-span-2 col-span-2">
                                    <label for="nombre_usuario" class="block text-sm/6 font-medium">Nickname</label>
                                    <div class="mt-2">
                                       <input id="nombre_usuario" type="text" name="nombre_usuario"
                                          class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                 </div>
                                 <div class="lg:col-span-1 col-span-2">
                                    <label for="password" class="block text-sm/6 font-medium">Contraseña</label>
                                    <div class="mt-2">
                                       <input id="password" type="password" name="password"
                                          class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                 </div>
                                 <div class="lg:col-span-1 col-span-2">
                                    <label for="password_confirmation" class="block text-sm/6 font-medium">Contraseña</label>
                                    <div class="mt-2">
                                       <input id="password_confirmation" type="password" name="password_confirmation"
                                          class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-base-content/20 placeholder:text-base-content/50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6" />
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="flex shrink-0 justify-end px-4 py-4">
                     <button type="button" command="close" commandfor="drawer" class="rounded-md bg-base-100 px-3 py-2 text-sm font-semibold shadow-xs inset-ring inset-ring-base-content/20 hover:bg-base-content/5">Cancelar</button>
                     <button type="submit" class="ml-4 inline-flex justify-center rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-primary/80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Registrar</button>
                  </div>
               </form>
            </el-dialog-panel>
         </div>
      </dialog>
   </el-dialog>
@endsection

@section('scripts')
   <script>
      const loginForm = document.getElementById('registrar_usuario');

      loginForm.addEventListener('submit', (e) => {
         e.preventDefault();
         peticion(loginForm, {
            resetForm: false,
            highlightInputs: true,
            showAlert: false
         });
      });
   </script>
@endsection
