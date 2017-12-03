<p class="ayudas-empty" ng-show="items.length === 0">
    Aún no tiene ayudas asignadas
</p>

{{-- UIBOOTSTRAP ACCORDION --}}
<uib-accordion close-others="true">
    <div uib-accordion-group class="addayudas panel-default" ng-repeat="i in items">

        <input type="hidden" name="ayuda[@{{$index}}]" ng-value="i.ayuda.id">

        <uib-accordion-heading>
            <span>@{{ i.ayuda.descripcion }}</span>
            <button class="pull-right btn-sm btn-outline btn-rest btn-delete" ng-click="remove($index)">
                <span class="glyphicon glyphicon-minus"></span>
                Quitar
            </button>
        </uib-accordion-heading>


        <div class="form-group">
            <label class="col-md-3">Monto base:</label>
            <div class="col-md-2">
                <input type="text" name="ayuda_monto[@{{$index}}]" ng-value="i.monto">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12">Detalle:</label>
            <div class="col-md-11">
                <textarea name="ayuda_detalle[@{{$index}}]" class="form-control noresize" cols="5" rows="5">@{{ i.detalle }}</textarea>
            </div>
        </div>
    </div>
</uib-accordion>
