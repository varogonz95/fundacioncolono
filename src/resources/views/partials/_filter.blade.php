<button class="close" type="button" ng-click="filter_active = false; filter_data.filter = filter_data.filtered ? filter_data.filter : null" data-toggle="collapse" data-target="#filter" style="font-size: 32px">&times;</button>
<div class="row" style="padding: 15px 0">
    {{-- PRIORIDAD --}}
    <div class="col-lg-2">
        <div class="form-group-sm form-group">
            <label>
                <input type="radio" name="filter" ng-model="filter_data.filter" value="prioridad"> Prioridad
                <!-- PUT THIS INTO DIRECTIVE -->
                <ngIf ng-if="filter_data.filter === 'prioridad'">
                    <input type="hidden" name="filterRel" value="expedientes">
                    <input type="hidden" name="property" value="prioridad">
                    <input type="hidden" name="comparator" value="=">
                    <input type="hidden" name="value" ng-value="filter_data.prioridad.id">
                </ngIf>
            </label>
            <select class="form-control" ng-model="filter_data.prioridad" ng-options="p as p.name for p in prioridades track by p.id"></select>
        </div>

    </div>

    {{-- ESTADO --}}
    <div class="col-lg-2">
        <div class="form-group-sm form-group">
            <label>
                <input type="radio" name="filter" ng-model="filter_data.filter" value="estado"> Estado
                <ngIf ng-if="filter_data.filter === 'estado'">
                    <input type="hidden" name="filterRel" value="expedientes">
                    <input type="hidden" name="property" value="estado">
                    <input type="hidden" name="comparator" value="=">
                    <input type="hidden" name="value" ng-value="filter_data.estado.id">
                </ngIf>
            </label>
            <select class="form-control" ng-model="filter_data.estado" ng-options="e as e.name for e in estados track by e.id"></select>
        </div>
    </div>

    {{-- REFERENTE --}}
    <div class="col-lg-2">
        <div class="form-group-sm form-group">
            <label>
                <input type="radio" name="filter" ng-model="filter_data.filter" value="referente"> Referente
                <ngIf ng-if="filter_data.filter === 'referente'">
                    <input type="hidden" name="filterRel" value="referente">
                    <input type="hidden" name="property" value="id">
                    <input type="hidden" name="comparator" value="=">
                    <input type="hidden" name="value" ng-value="filter_data.referente">
                </ngIf>
            </label>
            <br>
            <input 
                type="text" placeholder="-Seleccione un referente-" class="form-control" autocomplete="off" 
                ng-model="filter_data.referente" ng-hide="filter_data.referente.id === {{ $first_referente }}"
                uib-typeahead="r.id as r.descripcion for r in referentes | filter:$viewValue | limitTo: 20"
                typeahead-show-hint="true" typeahead-min-length="0" typeahead-input-formatter="formatter($model, referentes, 'id', 'descripcion')"
            />
        </div>
    </div>

    {{-- TIPO DE AYUDA --}}
    <div class="col-lg-2">
        <div class="form-group form-group-sm">
            <label>
                <input type="radio" name="filter" ng-model="filter_data.filter" value="ayuda"> Tipo de ayuda
                <ngIf ng-if="filter_data.filter === 'ayuda'">
                    <input type="hidden" name="filterRel" value="ayudas">
                    <input type="hidden" name="property" value="id">
                    <input type="hidden" name="comparator" value="=">
                    <input type="hidden" name="value" ng-value="filter_data.ayuda.id">
                </ngIf>
            </label>
            <select class="form-control" ng-model="filter_data.ayuda" ng-options="a as a.descripcion for a in ayudas track by a.id"></select>
        </div>
    </div>

    {{-- FECHA DE INGRESO --}}
    <div class="col-lg-2">
        <div class="form-group form-group-sm">
            <label>
                <input type="radio" name="filter" ng-model="filter_data.filter" value="fecha_creacion"> Fecha de ingreso
                <ngIf ng-if="filter_data.filter === 'fecha_creacion'">
                    <input type="hidden" name="filterRel" value="expedientes">
                    <input type="hidden" name="property" value="fecha_creacion">
                    <input type="hidden" name="comparator" value="between">
                    <input type="hidden" name="value[0]" ng-value="toStandardDate(filter_data.fecha_creacion.from)">
                    <input type="hidden" name="value[1]" ng-value="toStandardDate(filter_data.fecha_creacion.to)">
                </ngIf>
            </label>
            <br>
            <label class="text-muted" style="font-weight: 100">Desde:</label>
            <input
                type="text" class="form-control" placeholder="Fecha desde"
                ng-model="filter_data.fecha_creacion.from" ng-click="datePickers.openFrom = true"
                uib-datepicker-popup="dd/MM/yyyy" is-open="datePickers.openFrom"
            />
            <label class="text-muted" style="font-weight: 100">Hasta:</label>
            <input 
                type="text" class="form-control" placeholder="Fecha hasta"
                ng-click="datePickers.openTo = true" ng-model="filter_data.fecha_creacion.to" is-open="datePickers.openTo"
                uib-datepicker-popup="dd/MM/yyyy" datepicker-options="{minDate:filter_data.fecha_creacion.from}"
            />
        </div>
    </div>
</div>