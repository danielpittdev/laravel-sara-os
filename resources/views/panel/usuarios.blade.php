@extends('plantillas.panel.body')

@section('contenido')
   <div class="flex justify-between">
      <!-- Caja -->
      <div class="caja">
         <h1 class="font-medium text-xl">
            Usuarios
         </h1>
      </div>

      <!-- Caja -->
      <div class="caja">
         <el-dropdown class="inline-block">
            <button class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-base-100 px-3 py-2 text-sm font-semibold text-base-content shadow-xs inset-ring-1 inset-ring-base-content/15 hover:bg-base-200">
               Options
               <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="-mr-1 size-5 text-gray-400">
                  <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
               </svg>
            </button>

            <el-menu anchor="bottom end" popover
               class="w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-base-100 shadow-lg outline-1 outline-base-content/15 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
               <div class="p-1">
                  <button command="show-modal" commandfor="drawer" class="w-full group/item flex items-center px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:text-base-content focus:outline-hidden">

                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4.5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                     </svg>

                     Crear usuario
                  </button>
               </div>
            </el-menu>
         </el-dropdown>

      </div>
   </div>

   <section class="space-y-5">
      <div class="box">
         <table class="relative min-w-full divide-y divide-base-300">
            <thead>
               <tr>
                  <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-base-content sm:pl-6 lg:pl-8">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-base-content">Title</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-base-content">Email</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-base-content">Role</th>
                  <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-6 lg:pr-8">
                     <span class="sr-only">Edit</span>
                  </th>
               </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-base-100">

               @php
                  $usuarios = App\Models\Usuario::get();
               @endphp

               @foreach ($usuarios as $usuario)
                  <tr>
                     <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-base-content sm:pl-6 lg:pl-8">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                     <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">Front-end Developer</td>
                     <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ $usuario->email }}</td>
                     <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">Member</td>
                     <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                        <a href="{{ route('single_usuario', ['id' => $usuario->id]) }}" class="text-indigo-600 hover:text-indigo-900">Editar<span class="sr-only">, {{ $usuario->nombre }} {{ $usuario->apellido }}</span></a>
                     </td>
                  </tr>
               @endforeach

            </tbody>
         </table>
      </div>
   </section>
@endsection

@section('extras')
   <el-dialog>
      <dialog id="drawer" aria-labelledby="drawer-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-hidden bg-transparent not-open:hidden backdrop:bg-transparent">
         <el-dialog-backdrop class="absolute inset-0 bg-base-300/50 transition-opacity duration-500 ease-in-out data-closed:opacity-0"></el-dialog-backdrop>

         <div tabindex="0" class="absolute inset-0 pl-10 focus:outline-none sm:pl-16">
            <el-dialog-panel class="ml-auto block size-full max-w-md transform transition duration-500 ease-in-out data-closed:translate-x-full sm:duration-500">
               <div class="relative flex h-full flex-col overflow-y-auto bg-base-100 py-6 shadow-xl">
                  <div class="px-4 sm:px-6">
                     <div class="flex items-start justify-between">
                        <h2 id="drawer-title" class="text-base font-semibold text-base-content">Drawer</h2>
                        <div class="ml-3 flex h-7 items-center">
                           <button type="button" command="close" commandfor="drawer" class="relative rounded-md text-gray-400 hover:text-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                              <span class="absolute -inset-2.5"></span>
                              <span class="sr-only">Close panel</span>
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                 <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                           </button>
                        </div>
                     </div>
                  </div>
                  <div class="relative mt-6 flex-1 px-4 sm:px-6">

                     <div class="caja">
                        <form action="{{ route('usuarios.store') }}" method="post" class="space-y-5" id="crear_usuario">
                           @csrf

                           <div class="grid lg:grid-cols-2 grid-cols-1 gap-3">
                              <!-- Input -->
                              <div class="campo lg:col-span-1 col-span-1">
                                 <label for="nombre" class="block text-sm/6 font-medium text-base-content">Nombre</label>
                                 <div class="mt-2">
                                    <input id="nombre" type="text" name="nombre"
                                       class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                 </div>
                              </div>

                              <!-- Input -->
                              <div class="campo lg:col-span-1 col-span-1">
                                 <label for="apellido" class="block text-sm/6 font-medium text-base-content">Apellido</label>
                                 <div class="mt-2">
                                    <input id="apellido" type="text" name="apellido"
                                       class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                 </div>
                              </div>

                              <!-- Input -->
                              <div class="campo lg:col-span-2 col-span-1">
                                 <label for="email" class="block text-sm/6 font-medium text-base-content">Email</label>
                                 <div class="mt-2">
                                    <input id="email" type="email" name="email"
                                       class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                                 </div>
                              </div>

                              <!-- Botón enviar -->
                              <div class="col-span-2 mt-5 ml-auto">
                                 <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Guardar
                                 </button>
                              </div>

                           </div>
                        </form>

                        <!-- JS -->
                        <script>
                           const crear_usuario = document.getElementById('crear_usuario');

                           crear_usuario.addEventListener('submit', (e) => {
                              e.preventDefault();
                              peticion(crear_usuario, {
                                 resetForm: false,
                                 highlightInputs: true,
                                 showAlert: false,
                                 reload: true,
                              });
                           });
                        </script>
                     </div>

                  </div>
               </div>
            </el-dialog-panel>
         </div>
      </dialog>
   </el-dialog>
@endsection
