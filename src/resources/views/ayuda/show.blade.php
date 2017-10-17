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

            <div class="expediente-info @{{ ayuda.removed? 'removed editing' : '' }} @{{ ayuda.editable? 'editing' : '' }}">
                <div class="btn-group" ng-hide="ayuda.editable || ayuda.removed">
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
                <p>@{{ ayuda.pivot.monto | currency:"‎₡" }}</p>
                <span>Descripcion:</span>
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