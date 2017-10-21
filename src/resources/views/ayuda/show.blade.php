<article id="selectedayuda" class="col-md-10 col-md-offset-1" ng-controller="Ayudas_MainController">
    <header>
        <h3>
            Ayudas solicitadas
            <small>
                @{{ (selected.editable)? '(en edición)' : '' }}
            </small>
            <small>Monto total asignado: @{{ selected.montoTotal | currency:"‎₡" }}</small>
            <small>
                <button class="btn-rest btn-sm btn-show btn-outline">
                    <span class="glyphicon glyphicon-plus"></span>
                    Agregar ayuda
                </button>

                <button class="btn-rest btn-sm btn-outline btn-update" ng-show="update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0" ng-click="update()">
                    Guardar cambios
                </button>

                <button class="btn-rest btn-sm btn-outline btn-none" ng-show="update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0" ng-click="cancel()">
                    Cancelar
                </button>
            </small>
        </h3>
        <hr>
    </header>

    <div class="row">
        <section class="col-md-4" ng-repeat="ayuda in selected.ayudas">

<<<<<<< Updated upstream:src/resources/views/ayuda/show.blade.php
            <div class="expediente-info @{{ ayuda.removed? 'removed editing' : '' }} @{{ ayuda.editable? 'editing' : '' }}">
                <div class="btn-group" ng-hide="ayuda.editable || ayuda.removed">
=======
            <div class="expediente-info @{{ ayuda.editable? 'editing' : '' }}" ng-if="ayuda.editable">
                <div class="controls" ng-show="ayuda.editable">
                    <button type="button" class="btn-rest btn-outline btn-show" ng-click="updateAyuda(ayuda)">
                        <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                    <button type="button" class="close" title="Cancelar edición" ng-click="cancel(ayuda)">&times;</button>
                </div>
                @include('templates.ayuda.$edit_pivot')
            </div>

            <div class="expediente-info @{{ ayuda.removed? 'removed' : '' }}" ng-hide="ayuda.editable">
                <div class="btn-group" ng-hide="ayuda.removed">
>>>>>>> Stashed changes:src/resources/views/templates/ayuda/show.blade.php
                    <button class="btn-edit btn-rest btn-outline btn-sm" ng-click="edit(ayuda)">
                        <span class="glyphicon-pencil glyphicon"></span>
                        Editar
                    </button>
                    <button type="button" class="btn-rest btn-sm btn-delete btn-outline" ng-click="remove(ayuda)">
                        <span class="glyphicon glyphicon-minus"></span>
                        Quitar
                    </button>
                </div>

                <span>Tipo de ayuda:</span>
                <br>
                <h5>
                    <strong>@{{ ayuda.descripcion }}</strong>
                </h5>
                <span>Monto:</span>
                <br>
<<<<<<< Updated upstream:src/resources/views/ayuda/show.blade.php
                <p>@{{ ayuda.pivot.monto | currency:"‎₡" }}</p>
                <span>Descripcion:</span>
=======

                <p class="lead">@{{ ayuda.pivot.monto | currency:"‎₡" }}</p>
                <label>Descripcion:</label>
>>>>>>> Stashed changes:src/resources/views/templates/ayuda/show.blade.php
                <br>
                
                <p class="text-@{{ !ayuda.pivot.text_expanded? 'collapsed' : '' }}" ng-init="ayuda.pivot.text_expanded = false">
                    <span ng-init="ayuda.pivot.detalle_tmp = ayuda.pivot.detalle.substring(0,100)">@{{ ayuda.pivot.detalle_tmp }}</span>
                    <span ng-show="ayuda.pivot.detalle.length > 100 && ayuda.pivot.detalle_tmp.length <= 100" style="max-height: 20px; min-height: 20px">
                        ...
                        <br>
                        <a class="text-nowrap" href="#" ng-click="ayuda.pivot.detalle_tmp = ayuda.pivot.detalle; ayuda.pivot.text_expanded = true">ver más &raquo;</a>
                    </span>
                    <span ng-show="ayuda.pivot.detalle_tmp.length > 100" style="max-height: 20px; min-height: 20px">
                        <br>
                        <a class="text-nowrap" href="#" ng-click="ayuda.pivot.detalle_tmp = ayuda.pivot.detalle.substring(0,100); ayuda.pivot.text_expanded = false">&laquo; ver menos</a>
                    </span>
                </p>
            </div>
        </section>
    </div>
</article>