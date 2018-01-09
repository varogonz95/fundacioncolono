<article id="selectedinspector" class="col-md-4 col-md-offset-1" ng-class="{'editing': selected.editable}" ng-controller="Inspecotes_EditController">
    <header>
        <h3>
          Detalles del inspector
          <small>
              @{{ (selected.editable)? '(en edición)' : '' }}
          </small>
        </h3>
    </header>

    <section class="inspector-info form-horizontal" style="overflow-y: auto" ng-if="selected.editable">
        <div class="controls" ng-show="selected.editable">
            <button type="button" class="btn btn-outline btn-show" ng-click="commit()">
                <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
            <button type="button" class="close" title="Cancelar edición" ng-click="selected.editable = false">&times;</button>
        </div>

        {{-- INCLUDE EXPEDIENTE FORM COMPONENT --}}
        @include('templates.inspector.$edit')
    </section>


</article>
