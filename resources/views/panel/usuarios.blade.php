@extends('plantillas.panel.body')

@section('contenido')
   <h1 class="font-medium text-xl">
      Usuarios
   </h1>

   <section class="space-y-5">
      <div class="box">
         <table class="relative min-w-full divide-y divide-base-300">
            <thead>
               <tr>
                  <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
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
                     <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6 lg:pl-8">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
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
