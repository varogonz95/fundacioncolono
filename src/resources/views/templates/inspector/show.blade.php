<article id="selectedinspector" class="col-md-4 col-md-offset-1" ng-class="{'editing': selected.editable}">
    <header>
        <h3>
          Datos del usuario
          <small>
              @{{ (selected.editable)? '(en edición)' : '' }}
          </small>
        </h3>
    </header>

    <section class="inspector-info form-horizontal" style="overflow-y: auto" ng-if="selected.editable">
        <div class="controls" ng-show="selected.editable">
            <button type="button" class="btn btn-outline btn-show" ng-click="updateUsuario()">
                <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
            <button type="button" class="close" title="Cancelar edición" ng-click="selected.editable = false">&times;</button>
        </div>

        {{-- INCLUDE INSPECTOR FORM COMPONENT --}}
        @include('templates.inspector.$edit')
    </section>

    <section class="expediente-info" ng-class="" ng-hide="selected.editable">

        <button type="button" class="btn-outline btn btn-edit btn-sm" ng-click="edit()" ng-if="!selected.editable">
            <span class="glyphicon glyphicon-pencil"></span>
            <span class="hidden-xs">Editar</span>
        </button>

        <div class="expediente-info-item">
            <label>Correo: </label>
            <span>@{{ selected.usuario.email }}</span>
        </div>


        <div class="expediente-info-item">
            <label>Usuario: </label>
            <span>@{{ selected.usuario.username }}</span>
        </div>

        <div class="expediente-info-item">
            <label>Contraseña:<label>
            <div style="display:inline-block; min-width: 100px;" >
              <input style="border:none;width: 80%; margin-left:10px" class="form-group"type="@{{ visible ? 'text' : 'password' }}" value=" @{{ selected.usuario.password }}" readonly/>
              <span style="cursor: pointer" class="glyphicon glyphicon-eye-@{{ visible ? 'close' : 'open' }}" ng-click="mostrarPassword()"></span>
            </div>
        </div>

    </section>


</article>
