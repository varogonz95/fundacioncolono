@component('components.modals.bootstrapModal')

    @slot('id', 'ayudasModal')

    @slot('header')
        <h4 class="modal-title">Agregar ayudas</h4>
    @endslot

    <p class="text-danger text-center" ng-hide="ayudas.length > 0">
        <span class="glyphicon glyphicon-asterisk"></span>
        <strong>No hay mas ayudas para agregar</strong>
    </p>

    <div class="form-horizontal" ng-show="ayudas.length > 0">
        <div class="form-group">
            <label class="control-label col-md-4">Ayuda solicitada:</label>
            <div class="col-md-6 col-md-offset-1">
                <select class="form-control" ng-model="ayuda_selected" ng-options="a as a.descripcion for a in ayudas track by a.id">
                    <option value="" disabled selected>-Seleccionar ayuda-</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4">Monto base ₡:</label>
            <div class="col-md-6 col-md-offset-1">
                <input type="text" class="form-control" ng-model="monto" placeholder="(en colones)" value="0">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 col-md-offset-1">Detalle:</label>
            <div class="col-md-10 col-md-offset-1">
                <textarea cols="50" rows="5" class="form-control noresize" ng-model="detalle"></textarea>
            </div>
        </div>
    </div>

    @slot('footer')
        <div class="text-center">
            <button type="button" class="btn-primary btn" ng-click="add()" ng-disabled="!ayuda_selected" ng-show="ayudas.length > 0">Agregar</button>
        </div>
    @endslot

@endcomponent
