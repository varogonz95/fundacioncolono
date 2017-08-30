<div id="personrecords" class="animated" ng-controller="ExpedienteController">

    <header class="animatedModal-header">
        <button type="button" class="btn btn-sm btn-default close-animatedModal"><span class="glyphicon glyphicon-share-alt" style="transform:rotateY(180deg);margin-right:.5em"></span>Volver</button>
        <button type="button" class="btn btn-sm btn-success" ng-click="show()">Añadir expediente</button>
    </header>

    <div class="animatedModal-content" style="padding:0 1em">

        <section class="records empty col-lg-6 col-lg-push-3" ng-if="!persona.selected.expedientes.length">
            <h3 class="text-muted text-inline">Esta persona no tiene expedientes</h3>
        </section>

        <section class="records col-lg-6" ng-repeat="r in persona.selected.expedientes">

            <header class="page-header">
                <h4 class="text-inline">
                    <small class="text-block pull-left">Tipo de ayuda</small>
                    <span class="text-block pull-left">@{{r.ayuda.descripcion}}</span>
                </h4>
                <h5 class="text-inline">Fecha: @{{r.fecha_creacion.split(' ')[0] || 'sin fecha'}}</h5>
            </header>

            <article class="record-content @{{ r.editable? 'editing' : ''}}">

                <div class="pull-right text-right col-lg-3">
                    <div class="controls" ng-hide="r.editable">
                        <button type="button" class="btn-rest btn-edit" ng-click="r.editable = true"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button type="button" class="btn-rest btn-delete" ng-click="delete(r)"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>

                    <div class="controls" ng-show="r.editable">
                        <button type="button" class="btn btn-warning btn-sm" ng-click="update(r,$event)">Guardar cambios</button>
                        <button type="button" class="close" ng-click="r.editable = false">&times;</button>
                    </div>
                </div>

                <div class="pull-left col-lg-9">
                    <section class="record-info">
                        <span class="text-muted">Descripción:</span>
                        <p class="record-details text-justify" ng-hide="r.editable">@{{r.descripcion}}</p>
                        <textarea name="descripcion" class="form-control record-details" rows="5" ng-show="r.editable">@{{r.descripcion}}</textarea>
                    </section>

                    <section class="record-info">
                        <span class="text-muted">Recomendaciones:</span>
                        <p class="record-details text-justify" ng-hide="r.editable">@{{r.recomendaciones || 'Ninguna'}}</p>
                        <textarea name="recomendaciones" class="form-control record-details" rows="5" ng-show="r.editable">@{{r.recomendaciones}}</textarea>
                    </section>

                    <section class="record-perks">
                        <p>
                            <span class="text-muted">Prioridad:</span>
                            <span class="label label-@{{ r.prioridad === 1? 'info' : r.prioridad === 2? 'warning' : r.prioridad === 3? 'danger' : ''}} " ng-hide="r.editable">@{{ r.prioridad === 1? 'Baja' : r.prioridad === 2? 'Media' : r.prioridad === 3? 'Alta' : ''}}</span><br>
                            {{-- <div class="form-group col-lg-6" ng-show="r.editable"></div> --}}
                            <select class="form-control" name="prioridad" ng-show="r.editable" ng-model="r.prioridad">
                                <option ng-value="3">Alta (3)</option>
                                <option ng-value="2">Media (2)</option>
                                <option ng-value="1">Baja (1)</option>
                            </select>
                        </p>
                        <p>
                            <span class="text-muted">Monto: </span>
                            <span class="perk" ng-hide="r.editable">₡ @{{ r.monto | number:2}}</span>
                            <input class="form-control" type="number" name="monto" value="@{{ r.monto }}" ng-show="r.editable">
                        </p>
                    </section>
                </div>

            </article>

        </section>
    </div>
</div>
