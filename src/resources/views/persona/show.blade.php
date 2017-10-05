<article id="selectedpersona" class="col-md-4 col-md-offset-1 @{{ (selected.persona.editable)? 'editing' : '' }}" ng-controller="Personas_EditController">
    <header class="page-header">
        <h3>
            Datos de la persona
            <small>@{{ (selected.persona.editable)? '(en edición)' : '' }}</small>
        </h3>
    </header>

    <section class="expediente-info form-horizontal" ng-if="selected.persona.editable">
        <div class="controls">
            <button type="button" class="btn-outline btn-rest btn-show" ng-click="update()">
                <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
            <button type="button" class="close" title="Cancelar edición" ng-click="selected.persona.editable = false">&times;</button>
        </div>

        {{-- INCLUDE PERSONA FORM COMPONENT --}}
        @include('persona.$edit')

    </section>

    <section class="expediente-info" ng-hide="selected.persona.editable">

        <button type="button" class="btn-outline btn-rest btn-edit btn-sm" ng-click="edit()">
            <span class="glyphicon glyphicon-pencil"></span> Editar
        </button>

        <div class="expediente-info-item">
            <label>Cédula: </label>
            <span>@{{ selected.persona.cedula }}</span>
        </div>

        <div class="expediente-info-item">
            <div>
                <label>Nombre completo: </label>
                <span>@{{ selected.persona.nombre + ' ' + selected.persona.apellidos }}</span>
            </div>
        </div>

        <div class="expediente-info-item">
            <label>Teléfono(s): </label>
            <span>@{{ selected.persona.telefonos }}</span>
        </div>

        <div class="expediente-info-item">
            <label>Ubicación: </label>
            <span>
                @{{ selected.persona.provincia.name + ', ' + selected.persona.canton.name + ', ' + selected.persona.distrito.name }}
            </span>
        </div>

        <div class="expediente-info-item">
            <label>Dirección exacta: </label>
            <p>@{{ selected.persona.direccion }}</p>
        </div>

        <div class="expediente-info-item">
            <label>Contacto(s): </label>
            <p>@{{ selected.persona.contactos }}</p>
        </div>

    </section>
</article>
