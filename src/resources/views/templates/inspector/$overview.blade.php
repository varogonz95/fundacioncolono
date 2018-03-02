@component('components.animatedModal')

   @slot('id', 'show_modal')

   @slot('ngController', 'Inspectores_EditController')

   @slot('header_content')
       <div class="col-xs-2 col-md-1 controls">
           <button type="button" class="close pull-left close-animatedModal" title="Cerrar">&times;</button>
       </div>
       <div class="col-xs-10 text-left">
           <button type="button" class="btn btn-delete btn-sm btn-outline" title="ModificarEstado" ng-hide="selected.modificarEstado" ng-click="modificarEstado()">
               <span class="glyphicon glyphicon-briefcase"></span>
               <span class="hidden-xs"> @{{ selected.activo == 'Si' ? 'Deshabilitar':'Habilitar'}} inspector</span>
           </button>
       </div>
   @endslot

  <!-- @slot('content_classes', 'expediente-content') !-->

  <!-- DATOS DE LA PERSONA -->
  @include('templates.persona.show')


  <!-- INFORMACION DE LOS EXPEDIENTES ASIGNADOS -->
  @include('templates.visita.show')

  <!-- INFORMACION DEL INSPECTOR -->
  @include('templates.inspector.show')

@endcomponent
