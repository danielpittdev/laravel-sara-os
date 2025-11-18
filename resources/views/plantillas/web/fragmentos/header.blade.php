@php
   $paginas = [
       'inicio' => ['ruta' => 'web_inicio', 'icono' => 'mdi-home'],
   ];
@endphp

<header class="bg-base-100 fixed top-0 left-0 w-full z-100">
   <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
      <div class="flex items-center gap-x-12">
         <a href="/" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
         </a>
         <div class="hidden lg:flex lg:gap-x-12">
            @foreach ($paginas as $pagina => $param)
               <a href="{{ route($param['ruta']) }}" class="text-sm/6 font-semibold text-base-content">{{ ucfirst($pagina) }}</a>
            @endforeach
         </div>
      </div>
      <div class="flex lg:hidden">
         <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-base-content/40 hover:text-base-content">
            <span class="sr-only">Open main menu</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
               <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
         </button>
      </div>
      <div class="hidden lg:flex">
         <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-base-content">
            <button type="button" class="rounded-md bg-indigo-500 px-2.5 py-1.5 text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Iniciar sesión</button>
         </a>
      </div>
   </nav>
   <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
         <div tabindex="0" class="fixed inset-0 focus:outline-none">
            <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-base-100 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
               <div class="flex items-center justify-between">
                  <a href="/" class="-m-1.5 p-1.5">
                     <span class="sr-only">Your Company</span>
                     <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
                  </a>
                  <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-base-content/40 hover:text-base-content">
                     <span class="sr-only">Close menu</span>
                     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                     </svg>
                  </button>
               </div>
               <div class="mt-6 flow-root">
                  <div class="-my-6 divide-y divide-white/10">
                     <div class="space-y-2 py-6">
                        @foreach ($paginas as $pagina => $param)
                           <a href="{{ route($param['ruta']) }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-base-content hover:bg-white/5">{{ ucfirst($pagina) }}</a>
                        @endforeach
                     </div>
                     <div class="py-6">
                        <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-base-content hover:bg-white/5">
                           <button type="button" class="rounded-md bg-indigo-500 px-2.5 py-1.5 text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Iniciar sesión</button>
                        </a>
                     </div>
                  </div>
               </div>
            </el-dialog-panel>
         </div>
      </dialog>
   </el-dialog>
</header>
