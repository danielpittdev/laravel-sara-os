@extends('plantillas.blank.fullbody')

@section('contenido')
   <main class="relative isolate min-h-full">
      <img src="https://images.unsplash.com/photo-1545972154-9bb223aac798?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=3050&q=80&exp=8&con=-15&sat=-75" alt="" class="absolute inset-0 -z-10 size-full object-cover object-top" />
      <div class="mx-auto max-w-7xl px-6 py-32 text-center sm:py-40 lg:px-8">

         <img class="mx-auto w-40" src="/logo/light.svg" alt="">
         <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">Esta característica es Premium</h1>
         <p class="mt-6 text-lg font-medium text-pretty text-white/70 sm:text-xl/8">Para poder acceder a ella, por favor suscríbete a continuación</p>
         <div class="mt-10 flex justify-center gap-10 items-center">

            <form id="form_sub" action="{{ route('api_checkout_sub') }}">
               <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  Activar suscripción
               </button>
            </form>

            <a href="{{ route('panel_inicio') }}" class="text-sm/7 font-semibold text-white hover:text-white/90"><span aria-hidden="true">&larr;</span> Volver al panel</a>

         </div>
      </div>
   </main>
@endsection

@section('scripts')
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
@endsection
