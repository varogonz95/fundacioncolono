@extends('partials._modal')

@section('modal-id')
id="recordshowmodal"
@overwrite

@section('modal-title')
    <h4 class="modal-title">
        <span class="pull-left">Expediente de @{{ expediente.selected.persona.nombre + ' ' + expediente.selected.persona.apellidos }}</span>
        <a href="./history?id=@{{ expediente.selected.id }}" target="_blank" class="btn btn-default pull-right"><span class="glyphicon glyphicon-time"></span></a>
    </h4>
@overwrite

@section('modal-body')
    <section class="records col-lg-12">

        <header class="record-header page-header">
            <h4 class="text-inline">
                <small class="text-block pull-left">Tipo de ayuda</small>
                <span class="text-block pull-left">@{{expediente.selected.ayuda.descripcion}}</span>
            </h4>
            <h5 class="text-inline">Fecha: @{{expediente.selected.fecha_creacion.split(' ')[0] || 'sin fecha'}}</h5>
        </header>

        <article class="record-content @{{ expediente.selected.editable? 'editing' : ''}}">

            <div class="pull-right text-right col-lg-3 row">
                <div class="controls" ng-hide="expediente.selected.editable">
                    <button type="button" class="btn-rest btn-edit" ng-click="expediente.selected.editable = true"><span class="glyphicon glyphicon-pencil"></span></button>
                    <button type="button" class="btn-rest btn-delete" ng-click="delete(r)"><span class="glyphicon glyphicon-trash"></span></button>
                </div>

                <div class="controls" ng-show="expediente.selected.editable">
                    <button type="button" class="close" title="Cancelar edición" ng-click="expediente.selected.editable = false">&times;</button>
                </div>
            </div>

            <div class="pull-left col-lg-9">
                <section class="record-info">
                    <span class="text-muted">Descripción:</span>
                    <p class="record-details text-justify" ng-hide="expediente.selected.editable">@{{expediente.selected.descripcion}}</p>
                    <textarea name="descripcion" class="form-control record-details" rows="5" ng-show="expediente.selected.editable">@{{expediente.selected.descripcion}}</textarea>
                </section>

                <section class="record-info">
                    <span class="text-muted">Recomendaciones:</span>
                    <p class="record-details text-justify" ng-hide="expediente.selected.editable">@{{expediente.selected.recomendaciones || 'Ninguna'}}</p>
                    <textarea name="recomendaciones" class="form-control record-details" rows="5" ng-show="expediente.selected.editable">@{{expediente.selected.recomendaciones}}</textarea>
                </section>

                <section class="record-perks">
                    <p>
                        <span class="text-muted">Prioridad:</span>
                        <span class="label label-@{{ expediente.selected.prioridad === 1? 'info' : expediente.selected.prioridad === 2? 'warning' : expediente.selected.prioridad === 3? 'danger' : ''}} " ng-hide="expediente.selected.editable">@{{ expediente.selected.prioridad === 1? 'Baja' : expediente.selected.prioridad === 2? 'Media' : expediente.selected.prioridad === 3? 'Alta' : ''}}</span><br>
                        {{-- <div class="form-group col-lg-6" ng-show="expediente.selected.editable"></div> --}}
                        <select class="form-control" name="prioridad" ng-show="expediente.selected.editable" ng-model="expediente.selected.prioridad">
                            <option ng-value="3">Alta (3)</option>
                            <option ng-value="2">Media (2)</option>
                            <option ng-value="1">Baja (1)</option>
                        </select>
                    </p>
                    <p>
                        <span class="text-muted">Monto: </span>
                        <span class="perk" ng-hide="expediente.selected.editable">₡ @{{ expediente.selected.monto | number:2}}</span>
                        <input class="form-control" type="number" name="monto" value="@{{ expediente.selected.monto }}" ng-show="expediente.selected.editable">
                    </p>
                </section>
            </div>

        </article>

    </section>
@overwrite

@section('modal-footer')
    <footer class="modal-footer" ng-show="expediente.selected.editable">
        <button type="button" class="center-block btn btn-warning" ng-click="save(false)">Guardar cambios</button>
    </footer>
@overwrite
