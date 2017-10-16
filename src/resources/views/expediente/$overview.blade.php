 @component('components.animatedModal')
 
    @slot('id', 'show_modal')
    
    @slot('header_content')
        <button type="button" class="btn btn-sm btn-default close-animatedModal">
            <span class="glyphicon glyphicon-remove"></span>
            Cerrar
        </button>
        <button type="button" class="btn btn-sm btn-danger" ng-click="delete(selected)">
            Eliminar
            <span class="glyphicon glyphicon-trash"></span>
        </button>
    @endslot
    
    @slot('content_classes', 'expediente-content')

    <!-- DATOS DE LA PERSONA -->
    @include('persona.show')

    <!-- INFORMACION DEL EXPEDIENTE -->
    @include('expediente.show')

    <!-- INFORMACION DE LAS AYUDAS -->
    {{-- @include('ayuda.show') --}}
    <article id="selectedayuda" class="col-md-8 col-md-offset-2">

        <header class="page-header">
            <h3>
                Ayudas solicitadas
                <small>
                    @{{ (selected.editable)? '(en edición)' : '' }}
                </small>
                <small>Monto total asignado: @{{ selected.montoTotal | currency:"‎₡" }}</small>
                <small>
                    <button class="btn-rest btn-show btn-outline">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </small>
            </h3>
        </header>

        <section class="expediente-info col-md-4" ng-repeat="ayuda in selected.ayudas">

            <div class="controls">
                <button type="button" class="btn-rest btn-delete btn-outline" ng-click="">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
                <button class="btn-edit btn-rest btn-outline">
                    <span class="glyphicon-pencil glyphicon"></span>
                </button>
            </div>

            <span>Tipo de ayuda:</span>
            <br>
            <p>@{{ ayuda.descripcion }}</p>
            <span>Monto:</span>
            <br>
            <p>@{{ ayuda.pivot.monto | currency:"‎₡" }}</p>
            <span>Descripcion:</span>
            <br>
            <p class="text-">
                @{{ ayuda.pivot.detalle | limitTo:100 }}
                <span ng-if="ayuda.pivot.detalle.length > 100">
                    ...
                    <br>
                    <a class="text-nowrap" href="#" ng-click="">ver más »</a>
                </span>
            </p>

        </section>

    </article>

@endcomponent