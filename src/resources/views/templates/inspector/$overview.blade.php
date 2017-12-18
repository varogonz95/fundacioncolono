@component('components.animatedModal')

   @slot('id', 'show_modal')

   @slot('header_content')
       <div class="col-xs-2 col-md-1 controls">
           <button type="button" class="close pull-left close-animatedModal" title="Cerrar">&times;</button>
       </div>
   @endslot

   <!-- DATOS DE LA PERSONA -->
   @include('templates.persona.show')

@endcomponent
