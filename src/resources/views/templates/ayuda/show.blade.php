<article id="selectedayuda" class="col-md-10 col-md-offset-1" ng-controller="Ayudas_MainController">
    <header>
        <h3>
            Ayudas solicitadas
            <small>
                @{{ (selected.editable)? '(en edición)' : '' }}
            </small>
            <small class="text-nowrap">Monto total asignado: @{{ selected.montoTotal | currency:"‎₡" }}</small>
            <button class="btn-rest btn-sm btn-show btn-outline">
                <span class="glyphicon glyphicon-plus"></span>
                Agregar ayuda
            </button>
            <button class="btn-rest btn-sm btn-outline btn-update" ng-show="update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0" ng-click="update()">
                Guardar cambios
            </button>
            <button class="btn-rest btn-sm btn-outline btn-none" ng-show="update.ayudas.attachs.length > 0 || update.ayudas.detachs.length > 0 || update.ayudas.updates.length > 0" ng-click="cancelAll()">
                Cancelar
            </button>
        </h3>
        <!-- <h5>
            Leyenda:
            <small>lnd 1</small>
            <small>lnd2</small>
        </h5> -->
        <hr>
    </header>

    <div class="row">
        <section class="col-md-4" ng-repeat="ayuda in selected.ayudas">

            <div class="expediente-info @{{ ayuda.editable? 'editing' : '' }}" ng-if="ayuda.editable">
                <div class="controls" ng-show="ayuda.editable">
                    <button type="button" class="btn-rest btn-outline btn-show" ng-click="updateAyuda(ayuda)">
                        <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                    <button type="button" class="close" title="Cancelar edición" ng-click="cancel()">&times;</button>
                </div>
                @include('templates.ayuda.$edit_pivot')
            </div>

            <div class="expediente-info @{{ ayuda.removed? 'removed' : '' }}" ng-hide="ayuda.editable">
                <div class="btn-group" ng-hide="ayuda.removed">
                    <button class="btn-edit btn-rest btn-outline btn-sm" ng-click="edit(ayuda)">
                        <span class="glyphicon-pencil glyphicon"></span>
                        <span class="hidden-xs">Editar</span>
                    </button>
                    <button type="button" class="btn-rest btn-sm btn-delete btn-outline" ng-click="remove(ayuda)">
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
                <p class="text-@{{ !ayuda.pivot.text_expanded? 'collapsed' : '' }}" ng-init="ayuda.pivot.text_expanded = false">
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