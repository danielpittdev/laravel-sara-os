@php
   $paginas = [
       'inicio' => ['ruta' => 'panel_inicio', 'icono' => 'mdi-home'],
       'usuarios' => ['ruta' => 'panel_usuarios', 'icono' => 'mdi-home'],
   ];
@endphp

<el-dialog>
   <dialog id="sidebar" class="backdrop:bg-transparent lg:hidden">
      <el-dialog-backdrop class="fixed inset-0 bg-base-300/50 transition-opacity duration-300 ease-linear data-closed:opacity-0"></el-dialog-backdrop>

      <div tabindex="0" class="fixed inset-0 flex focus:outline-none">
         <el-dialog-panel class="group/dialog-panel relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out data-closed:-translate-x-full">
            <div class="absolute top-0 left-full flex w-16 justify-center pt-5 duration-300 ease-in-out group-data-closed/dialog-panel:opacity-0">
               <button type="button" command="close" commandfor="sidebar" class="-m-2.5 p-2.5">
                  <span class="sr-only">Close sidebar</span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-base-content">
                     <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
               </button>
            </div>

            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="relative flex grow flex-col gap-y-5 overflow-y-auto bg-base-100 px-6 pb-2 ring-1 ring-white/10">
               <div class="relative flex h-16 shrink-0 items-center">
                  <img src="{{ asset('/logo/main.svg') }}" alt="{{ env('APP_NAME') }}" class="h-8 w-auto" />
               </div>
               <nav class="flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                     <li>
                        <ul role="list" class="-mx-2 space-y-1">
                           @foreach ($paginas as $pagina => $param)
                              <li>
                                 <a href="{{ route($param['ruta']) }}"
                                    class="{{ request()->routeIs($param['ruta']) ? 'bg-base-content/3 hover:bg-base-content/5 text-base-content' : 'hover:bg-base-content/5' }} group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-base-content">
                                    {{ ucfirst($pagina) }}
                                 </a>
                              </li>
                           @endforeach
                        </ul>
                     </li>
                     <li class="hidden">
                        <div class="text-xs/6 font-semibold text-gray-400">Your teams</div>
                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                           <li>
                              <!-- Current: "bg-gray-800 text-base-content", Default: "text-gray-400 hover:text-base-content hover:bg-white/5" -->
                              <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-white/5 hover:text-base-content">
                                 <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:border-white/20 group-hover:text-base-content">H</span>
                                 <span class="truncate">Heroicons</span>
                              </a>
                           </li>
                           <li>
                              <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-white/5 hover:text-base-content">
                                 <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:border-white/20 group-hover:text-base-content">T</span>
                                 <span class="truncate">Tailwind Labs</span>
                              </a>
                           </li>
                           <li>
                              <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-white/5 hover:text-base-content">
                                 <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:border-white/20 group-hover:text-base-content">W</span>
                                 <span class="truncate">Workcation</span>
                              </a>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </nav>
            </div>
         </el-dialog-panel>
      </div>
   </dialog>
</el-dialog>

<!-- Static sidebar for desktop -->
<div class="hidden bg-base-100 lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
   <!-- Sidebar component, swap this element with another sidebar if you like -->
   <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-base-content/10 px-6">
      <div class="flex h-16 shrink-0 items-center">
         <a href="{{ route('panel_inicio') }}">
            <img src="{{ asset('/logo/main.svg') }}" alt="{{ env('APP_NAME') }}" class="h-8 w-auto" />
         </a>
      </div>
      <nav class="flex flex-1 flex-col">
         <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
               <ul role="list" class="-mx-2 space-y-1">

                  @foreach ($paginas as $pagina => $param)
                     <li>
                        <a href="{{ route($param['ruta']) }}"
                           class="{{ request()->routeIs($param['ruta']) ? 'text-base-content' : 'text-base-content/60' }} hover:bg-base-content/5 hover:pl-2.5 duration-200 group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                           {{ ucfirst($pagina) }}
                        </a>
                     </li>
                  @endforeach
               </ul>
            </li>
            <li class="hidden">
               <div class="text-xs/6 font-semibold text-gray-400">Your teams</div>
               <ul role="list" class="-mx-2 mt-2 space-y-1">
                  <li>
                     <!-- Current: "bg-gray-800 text-base-content", Default: "text-gray-400 hover:text-base-content hover:bg-white/5" -->
                     <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-white/5 hover:text-base-content">
                        <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-base-content">H</span>
                        <span class="truncate">Heroicons</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-white/5 hover:text-base-content">
                        <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-base-content">T</span>
                        <span class="truncate">Tailwind Labs</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-white/5 hover:text-base-content">
                        <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-base-content">W</span>
                        <span class="truncate">Workcation</span>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="-mx-6 mt-auto hover:bg-base-300 ">
               <a href="{{ route('panel_ajustes') }}" class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-base-content hover:bg-white/5">
                  <img src="
            @if (Auth::user()->avatar) {{ Storage::url(Auth::user()->avatar) }}
            @else /media/panel/avatar.webp @endif
            " alt=""
                     class="size-8 rounded-full bg-base-100 border border-base-content/20 outline -outline-offset-1 outline-white/10" />
                  <span class="sr-only">Tu perfil</span>
                  <span aria-hidden="true">{{ auth()->user()->nombre . ' ' . auth()->user()->apellido }}</span>
               </a>
            </li>
         </ul>
      </nav>
   </div>
</div>

<div class="sticky top-0 z-40 flex items-center gap-x-6 bg-base-100 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
   <button type="button" command="show-modal" commandfor="sidebar" class="-m-2.5 p-2.5 text-gray-400 hover:text-base-content/50 lg:hidden">
      <span class="sr-only">Open sidebar</span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
         <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
   </button>
   <a href="{{ route('panel_ajustes') }}" class="ml-auto">
      <span class="sr-only">Tu perfil</span>
      <img src="
            @if (Auth::user()->avatar) {{ Storage::url(Auth::user()->avatar) }}
            @else /media/panel/avatar.webp @endif
            " alt=""
         class="size-8 rounded-full bg-base-100 border border-base-content/20 outline -outline-offset-1 outline-white/10" />
   </a>
</div>
