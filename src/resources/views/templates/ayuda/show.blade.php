<article id="selectedayuda" class="col-md-10 col-md-offset-1" ng-controller="Ayudas_EditController">
    <header>
        <h3>
            Ayudas solicitadas
            <small class="text-nowrap">Monto total asignado: @{{ selected.montoTotal | currency:"‎₡" }}</small>
            <ngIf ng-if="!selected.archivado">
                <button class="btn btn-sm btn-show btn-outline">
                    <span class="glyphicon glyphicon-plus"></span>
                    Agregar ayuda
                </button>
                <button class="btn btn-sm btn-outline btn-update" ng-show="update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0" ng-click="updateAyudas()">
                    Guardar cambios
                </button>
                <button class="btn btn-sm btn-outline btn-none" ng-show="update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0" ng-click="cancelAll()">
                    Cancelar
                </button>
            </ngIf>
        </h3>
        <hr>
    </header>

    <div class="row">
        <section class="col-md-4" ng-repeat="ayuda in selected.ayudas">

            <div class="expediente-info" ng-if="ayuda.editable && !selected.archivado" ng-class="{'editing': ayuda.editable}">
                <div class="controls" ng-show="ayuda.editable">
                    <button type="button" class="btn btn-outline btn-show" ng-click="commit(ayuda)">
                        <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                    <button type="button" class="close" title="Cancelar edición" ng-click="cancel(ayuda)">&times;</button>
                </div>
                @include('templates.ayuda.$edit_pivot')
            </div>

            <div class="expediente-info" ng-hide="ayuda.editable" ng-class="{'cached': ayuda.removed || ayuda.changed, 'archived': selected.archivado, 'text-expanded': ayuda.pivot.text_expanded}">

                <div class="row change-state" ng-show="ayuda.removed || ayuda.changed">
                    <strong>
                        Marcado para @{{ ayuda.removed ? 'eliminar' : ayuda.changed ? 'actualizar' : '' }}
                    </strong>
                    <button class="btn btn-outline btn-show btn-sm" ng-click="revert(ayuda)">
                        <span class="glyphicon glyphicon-repeat" style="transform: rotateY(180deg)"></span>
                        <span class="hidden-xs">Revertir cambios</span>
                    </button>
                </div>

                <div class="btn-group" ng-hide="ayuda.removed" ng-if="!selected.archivado">
                    <button class="btn-edit btn btn-outline btn-sm" ng-click="edit(ayuda)">
                        <span class="glyphicon-pencil glyphicon"></span>
                        <span class="hidden-xs">Editar</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-delete btn-outline" ng-hide="ayuda.changed" ng-click="remove(ayuda)">
                        <span class="glyphicon glyphicon-minus"></span>
                        <span class="hidden-xs">Quitar</span>
                    </button>
                </div>

                <label>Tipo de ayuda:</label>
                <h5 class="lead">@{{ ayuda.descripcion }}</h5>
                <label>Monto:</label>
                <br>
                <p class="lead">@{{ ayuda.pivot.monto | currency:"‎₡" }}</p>
                <label>Descripcion:</label>
                <br>
                <p ng-class="{'text-collapsed': !ayuda.pivot.text_expanded}" ng-init="ayuda.pivot.text_expanded = false">
                    <span ng-init="ayuda.pivot.detalle_tmp = ayuda.pivot.detalle.substring(0,200)">@{{ ayuda.pivot.detalle_tmp }}</span>
                    <span ng-show="ayuda.pivot.detalle.length > 200 && ayuda.pivot.detalle_tmp.length <= 200" class="text-length-toggle">
                        ...
                        <br>
                        <a class="text-nowrap" href="#" ng-click="ayuda.pivot.detalle_tmp = ayuda.pivot.detalle; ayuda.pivot.text_expanded = true">ver más &raquo;</a>
                    </span>
                    <span ng-show="ayuda.pivot.detalle_tmp.length > 200" style="max-height: 20px; min-height: 20px">
                        <br>
                        <a class="text-nowrap" href="#" ng-click="ayuda.pivot.detalle_tmp = ayuda.pivot.detalle.substring(0,200); ayuda.pivot.text_expanded = false">&laquo; ver menos</a>
                    </span>
                </p>
            </div>
        </section>
    </div>
</article>