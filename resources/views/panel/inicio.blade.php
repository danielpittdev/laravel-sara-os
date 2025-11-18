@extends('plantillas.panel.body')

@section('contenido')
   <h1 class="font-medium text-xl">
      Lista de contenidos
   </h1>

   <section class="space-y-5">
      <h2 class="font-medium">
         Formularios
      </h2>

      <!-- JS incluído -->
      <div class="box p-5 max-w-md">
         <div class="caja">
            <form action="{{ route('api_test') }}" method="post" class="space-y-5" id="formulario">
               <div class="grid lg:grid-cols-2 grid-cols-1 gap-3">

                  <!-- Input -->
                  <div class="campo">
                     <label for="campo" class="block text-sm/6 font-medium text-base-content">Campo</label>
                     <div class="mt-2">
                        <input id="campo" type="email" name="campo" placeholder="Datos del campo"
                           class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/12 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                     </div>
                  </div>

                  <!-- Select -->
                  <div class="campo">
                     <label for="select" class="block text-sm/6 font-medium text-base-content">Asignar a</label>
                     <el-select id="select" name="selected" value="" class="mt-2 block">
                        <button type="button"
                           class="grid w-full cursor-default grid-cols-1 rounded-md bg-base-100 py-1.5 pr-2 pl-3 text-left text-base-content outline-1 -outline-offset-1 outline-base-content/15 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6">
                           <el-selectedcontent class="col-start-1 row-start-1 truncate pr-6">Selecciona una opción</el-selectedcontent>
                           <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="col-start-1 row-start-1 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                              <path
                                 d="M5.22 10.22a.75.75 0 0 1 1.06 0L8 11.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-2.25 2.25a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 0 1 0-1.06ZM10.78 5.78a.75.75 0 0 1-1.06 0L8 4.06 6.28 5.78a.75.75 0 0 1-1.06-1.06l2.25-2.25a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1 0 1.06Z"
                                 clip-rule="evenodd" fill-rule="evenodd" />
                           </svg>
                        </button>

                        <el-options anchor="bottom start" popover
                           class="max-h-60 w-(--button-width) overflow-auto rounded-md bg-base-100 p-1 text-base shadow-lg outline-1 outline-base-content/15 [--anchor-gap:--spacing(1)] data-leave:transition data-leave:transition-discrete data-leave:duration-100 data-leave:ease-in data-closed:data-leave:opacity-0 sm:text-sm">

                           <!-- opción -->
                           <el-option value="1" class="group/option relative block cursor-default py-2 pr-9 pl-3 text-base-content select-none focus:bg-indigo-600 focus:text-white focus:outline-hidden">
                              <span class="block truncate font-normal group-aria-selected/option:font-semibold">Opción para remarcar</span>
                              <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600 group-not-aria-selected/option:hidden group-focus/option:text-white in-[el-selectedcontent]:hidden">
                                 <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                    <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                                 </svg>
                              </span>
                           </el-option>

                        </el-options>
                     </el-select>
                  </div>

                  <!-- Textarea -->
                  <div class="campo col-span-2">
                     <div>
                        <label for="comentario" class="block text-sm/6 font-medium text-base-content">Comentario</label>
                        <div class="mt-2">
                           <textarea id="comentario" name="comentario" rows="4"
                              class="block w-full rounded-md bg-base-100 px-3 py-1.5 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/15 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                        </div>
                     </div>
                  </div>

                  <!-- Toggle -->
                  <div class="campo col-span-2">
                     <div class="flex items-center justify-between">
                        <span class="flex grow flex-col">
                           <label id="availability-label" class="text-sm/6 font-medium text-base-content">Available to hire</label>
                           <span id="availability-description" class="text-sm text-base-content/50">Nulla amet tempus sit accumsan. Aliquet turpis sed sit lacinia.</span>
                        </span>
                        <div class="group relative inline-flex w-11 shrink-0 rounded-full bg-base-300 p-0.5 inset-ring inset-ring-base-content/15 outline-offset-2 outline-indigo-600 transition-colors duration-200 ease-in-out has-checked:bg-indigo-600 has-focus-visible:outline-2">
                           <span class="size-5 rounded-full bg-white shadow-xs transition-transform duration-200 ease-in-out group-has-checked:translate-x-5"></span>
                           <input id="availability" type="checkbox" name="availability" aria-labelledby="availability-label" aria-describedby="availability-description" class="absolute inset-0 appearance-none focus:outline-hidden" />
                        </div>
                     </div>
                  </div>

                  <!-- Combo -->
                  <div class="campo col-span-2">
                     <label for="autocomplete" class="block text-sm/6 font-medium text-base-content">Autocompletado</label>
                     <el-autocomplete class="relative mt-2 block">
                        <input id="autocomplete" name="autocomplete" type="text"
                           class="block w-full rounded-md bg-base-100 py-1.5 pr-12 pl-3 text-base text-base-content outline-1 -outline-offset-1 outline-base-content/15 placeholder:text-base-content/50 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2">
                           <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-gray-400">
                              <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                           </svg>
                        </button>

                        <el-options anchor="bottom end" popover
                           class="max-h-60 w-(--input-width) overflow-auto rounded-md bg-base-100 p-1 text-base shadow-lg outline outline-base-content/15 transition-discrete [--anchor-gap:--spacing(1)] data-leave:transition data-leave:duration-100 data-leave:ease-in data-closed:data-leave:opacity-0 sm:text-sm">
                           <el-option value="Leslie Alexander" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Leslie Alexander</el-option>
                           <el-option value="Michael Foster" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Michael Foster</el-option>
                           <el-option value="Dries Vincent" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Dries Vincent</el-option>
                           <el-option value="Lindsay Walton" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Lindsay Walton</el-option>
                           <el-option value="Courtney Henry" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Courtney Henry</el-option>
                           <el-option value="Tom Cook" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Tom Cook</el-option>
                           <el-option value="Whitney Francis" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Whitney Francis</el-option>
                           <el-option value="Leonard Krasner" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Leonard Krasner</el-option>
                           <el-option value="Floyd Miles" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Floyd Miles</el-option>
                           <el-option value="Emily Selman" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Emily Selman</el-option>
                           <el-option value="Kristin Watson" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Kristin Watson</el-option>
                           <el-option value="Emma Dorsey" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Emma Dorsey</el-option>
                           <el-option value="Alicia Bell" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Alicia Bell</el-option>
                           <el-option value="Jenny Wilson" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Jenny Wilson</el-option>
                           <el-option value="Anna Roberts" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Anna Roberts</el-option>
                           <el-option value="Benjamin Russel" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Benjamin Russel</el-option>
                           <el-option value="Jeffrey Webb" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Jeffrey Webb</el-option>
                           <el-option value="Kathryn Murphy" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Kathryn Murphy</el-option>
                           <el-option value="Lawrence Hunter" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Lawrence Hunter</el-option>
                           <el-option value="Yvette Armstrong" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Yvette Armstrong</el-option>
                           <el-option value="Angela Fisher" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Angela Fisher</el-option>
                           <el-option value="Blake Reid" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Blake Reid</el-option>
                           <el-option value="Hector Gibbons" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Hector Gibbons</el-option>
                           <el-option value="Fabricio Mendes" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Fabricio Mendes</el-option>
                           <el-option value="Jillian Steward" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Jillian Steward</el-option>
                           <el-option value="Chelsea Hagon" class="block truncate px-3 py-2 text-base-content select-none aria-selected:bg-indigo-600 aria-selected:text-white">Chelsea Hagon</el-option>
                        </el-options>
                     </el-autocomplete>

                  </div>

                  <!-- Checkbox -->
                  <div class="campo col-span-2">
                     <div class="space-y-5">
                        <div class="flex gap-3">
                           <div class="flex h-6 shrink-0 items-center">
                              <div class="group grid size-4 grid-cols-1">
                                 <input id="checkbox" type="checkbox" name="checkbox" checked aria-describedby="comments-description"
                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-base-content/15 bg-base-content checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-base-content/15 disabled:bg-base-100 disabled:checked:bg-base-100 forced-colors:appearance-auto" />
                                 <svg viewBox="0 0 14 14" fill="none" class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-has-checked:opacity-100" />
                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-has-indeterminate:opacity-100" />
                                 </svg>
                              </div>
                           </div>
                           <div class="text-sm/6">
                              <label for="checkbox" class="font-medium text-base-content">Checkbox</label>
                              <p id="comments-description" class="text-base-content/50">Activar para tener notificaciones.</p>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Botón enviar -->
                  <div class="col-span-2">
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

   <section class="space-y-5">
      <h2 class="font-medium">
         Drawer
      </h2>

      <!-- Drawer -->
      <button command="show-modal" commandfor="drawer" class="rounded-md bg-indigo-600 text-white px-2.5 py-1.5 text-sm font-semibold hover:bg-indigo-500">Open drawer</button>

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
                     Drawer de ejemplo
                  </div>
               </div>
            </el-dialog-panel>
         </div>
      </dialog>
   </el-dialog>
@endsection
