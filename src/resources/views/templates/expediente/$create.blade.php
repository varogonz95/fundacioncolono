
@component('components.forms.expediente')

    @slot('descripcion_model', 'descripcion')
    @slot('descripcion_value', '')

    @slot('hasReferenteOtro_model', 'hasReferenteOtro')
    @slot('hasReferenteOtro_value', 'hasReferenteOtro')

    @slot('referente_otro_model', 'referente_otro')
    @slot('newReferente_model', 'newReferente')
    @slot('newReferente_value', 'newReferente')

    @slot('referente_model', 'referente')
    @slot('referentes_list', 'referentes')
    @slot('referentes_limit', '20')

    @slot('prioridad_model', 'prioridad')
    @slot('prioridad_list', 'prioridades')

    @slot('estado_model', 'estado')
    @slot('estados_list', 'estados')

    {{-- THIS CONTENT POPULATES '$slot' VARIABLE --}}
    <hr>

    <div class="form-group">
        <label class="control-label col-sm-4" for="ayuda">Ayuda solicitada:</label>

        <button class="btn-rest btn-outline btn-show" type="button" ng-click="addAyuda()"><span class="glyphicon glyphicon-plus"></span> Agregar ayuda</button>
        <span class="text-danger text-nowrap" ng-show="invalid_add">Debe seleccionar un tipo de ayuda</span>

        <div class="col-sm-10 col-sm-offset-2" ng-repeat="as in ayudas_selected">

            <hr ng-hide="$first">

            <div class="controls @{{ ayudas_selected[$index].$invalid? 'has-error' : '' }}">
                <select class="form-control danger" name="ayuda[@{{ $index }}]" ng-model="ayudas_selected[$index]" ng-options="ayuda.descripcion for ayuda in ayudas track by ayuda.id" ng-change="ayudaChanged(ayudas_selected[$index], $index)" convert-to-number required>
                    <option value="" disabled>-Seleccionar tipo de ayuda-</option>
                </select>

                <ng-show ng-show="ayudas_selected[$index].id && !ayudas_selected[$index].$invalid">
                    <p class="help-block">Detalle:</p>
                    <textarea class="form-control noresize" name="ayuda.detalle[@{{ $index }}]" ng-model="ayudas_selected[$index].detalle" rows="5" cols="50" required></textarea>
                </ng-show>

                <ng-show ng-show="estado.id === 1 && ayudas_selected[$index].id && !invalid_add">
                    <p class="help-block">Monto:</p>
                    <input class="form-control" type="text" name="ayuda.monto[@{{ $index }}]" placeholder="Monto en colones" required>
                </ng-show>

                <p class="help-block" ng-show="ayudas_selected[$index].$invalid"><small class="text-danger">Cada tipo de ayuda debe ser <strong><u>único</u></strong></small></p>

                <button type="button" class="btn btn-danger" ng-click="removeAyuda(as)" ng-if="!$first"><span class="glyphicon glyphicon-ban-circle"></span> Quitar</button>
            </div>
        </div>
    </div>

    {{-- FINALLY, THE SUBMIT BUTTTON --}}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="center-block btn btn-primary" ng-disabled="newexpediente.$invalid">Guardar expediente</button>
        </div>
    </div>

    {{-- @include('templates.ayuda.$add_pivot') --}}

@endcomponent
