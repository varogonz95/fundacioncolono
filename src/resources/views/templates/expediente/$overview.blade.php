 @component('components.animatedModal')
 
    @slot('id', 'show_modal')
    
    @slot('header_content')
        <div class="col-xs-2 col-md-1 controls">
            <button type="button" class="close pull-left close-animatedModal" title="Cerrar">&times;</button>
        </div>
        <div class="col-xs-10 text-left">
            <button type="button" class="btn-rest btn-delete btn-sm btn-outline" title="Eliminar" ng-click="delete()">
                <span class="glyphicon glyphicon-trash"></span>
                <span class="hidden-xs">Eliminar</span>
            </button>
            <a href="expedientes/@{{ selected.id }}/history" target="_blank" class="btn-rest btn-outline btn-sm btn-edit" title="Historial de cambios">
                <span class="glyphicon glyphicon-time"></span>
                <span class="hidden-xs">Historial de cambios</span>
            </a>
        </div>
    @endslot
    
    @slot('content_classes', 'expediente-content')

    <!-- DATOS DE LA PERSONA -->
    @include('templates.persona.show')

    <!-- INFORMACION DEL EXPEDIENTE -->
    @include('templates.expediente.show')

    <!-- INFORMACION DE LAS AYUDAS -->
    @include('templates.ayuda.show')
    
@endcomponent