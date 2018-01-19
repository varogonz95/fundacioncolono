@component('components.animatedModal')

   @slot('id', 'show_modal')

   @slot('ngController', 'Inspectores_EditController')

   @slot('header_content')
	   <div class="col-xs-2 col-md-1 controls">
		   <button type="button" class="close pull-left close-animatedModal" title="Cerrar">&times;</button>
	   </div>
	   <div class="col-xs-10 text-left">
		   <button type="button" class="btn btn-delete btn-sm btn-outline" title="Deshabilitar inspector" ng-show="selected.activo" ng-click="modificarEstado()">
			   <span class="glyphicon glyphicon-trash"></span>
			   <span class="hidden-xs"> Deshabilitar inspector</span>
		   </button>
		   <button type="button" class="btn btn-show btn-sm btn-outline" title="Habilitar inspector" ng-hide="selected.activo" ng-click="modificarEstado()">
				<span class="glyphicon glyphicon-refresh"></span>
				<span class="hidden-xs"> Habilitar inspector</span>
			</button>
	   </div>
   @endslot

  {{-- @slot('content_classes', 'expediente-content') --}}

  <!-- DATOS DE LA PERSONA -->
  @include('templates.persona.show')


  <!-- INFORMACION DE LOS EXPEDIENTES ASIGNADOS -->
  @include('templates.inspector_expediente.show')

  <!-- INFORMACION DEL INSPECTOR -->
  @include('templates.inspector.show')

@endcomponent
