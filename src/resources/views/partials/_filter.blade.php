<div class="row" style="padding: 15px 0">
    <form ng-submit="filter_pichudo()">

        {{-- PRIORIDAD --}}
        <div class="col-lg-2">
            <div class="form-group-sm form-group">
                <label>
                    Prioridad
                    <input type="radio" name="filter" ng-model="filter_data.filter" value="prioridad">
                    <!-- PUT THIS INTO DIRECTIVE -->
                    <ngIf ng-if="filter_data.filter === 'prioridad'">
                        <input type="hidden" name="relationship" value="expedientes">
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
                    Estado
                    <input type="radio" name="filter" ng-model="filter_data.filter" value="estado">
                    <ngIf ng-if="filter_data.filter === 'estado'">
                        <input type="hidden" name="relationship" value="expedientes">
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
                    Referente
                    <input type="radio" name="filter" ng-model="filter_data.filter" value="referente">                    
                    <ngIf ng-if="filter_data.filter === 'referente'">
                        <input type="hidden" name="relationship" value="referente">
                        <input type="hidden" name="property" value="id">
                        <input type="hidden" name="comparator" value="=">
                        <input type="hidden" name="value" ng-value="filter_data.referente">
                    </ngIf>
                </label><br>
                <!-- <label style="font-weight:100">
                    Otro referente:
                    <input type="checkbox" ng-model="filter_data.referente.id" ng-value="{{ \App\Models\Referente::first()->id }}">
                </label> -->
                <input 
                    type="text" placeholder="-Seleccione un referente-" 
                    class="form-control" autocomplete="off" ng-model="filter_data.referente"
                    uib-typeahead="r.id as r.descripcion for r in referentes | filter:$viewValue | limitTo: 20"
                    ng-hide="filter_data.referente.id === {{ $first_referente }}" typeahead-show-hint="true" typeahead-min-length="0" 
                    typeahead-input-formatter="formatter($model, referentes, 'id', 'descripcion')"
                    />
            </div>    
        </div>
        
        {{-- TIPO DE AYUDA --}}
        <div class="col-lg-2">
            <div class="form-group form-group-sm">
                <label>
                    Tipo de ayuda
                    <input type="radio" name="filter" ng-model="filter_data.filter" value="ayuda">
                    <ngIf ng-if="filter_data.filter === 'ayuda'">
                        <input type="hidden" name="relationship" value="ayudas">
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
                    Fecha de ingreso
                    <input type="radio" name="filter" ng-model="filter_data.filter" value="fecha_creacion">
                    <ngIf ng-if="filter_data.filter === 'fecha_creacion'">
                        <input type="hidden" name="relationship" value="expedientes">
                        <input type="hidden" name="property" value="fecha_creacion">
                        <input type="hidden" name="comparator" value="between">
                        <input type="hidden" name="value[0]" ng-value="toStandardDate(filter_data.fecha_creacion.from)">
                        <input type="hidden" name="value[1]" ng-value="toStandardDate(filter_data.fecha_creacion.to)">
                    </ngIf>
                </label>
                <br>
                <label class="text-muted" style="font-weight: 100">Desde:</label>
                <input 
                    type="text" class="form-control"
                    uib-datepicker-popup="dd/MM/yyyy" 
                    ng-click="datePickers.openFrom = true" placeholder="Fecha desde"
                    ng-model="filter_data.fecha_creacion.from" is-open="datePickers.openFrom"
                />
                <label class="text-muted" style="font-weight: 100">Hasta:</label>
                <input 
                    type="text" class="form-control" 
                    ng-click="datePickers.openTo = true" placeholder="Fecha hasta"
                    ng-model="filter_data.fecha_creacion.to" is-open="datePickers.openTo"
                    uib-datepicker-popup="dd/MM/yyyy" datepicker-options="{minDate:filter_data.fecha_creacion.from}"
                />
            </div>
        </div>
        
        {{-- UBICACION --}}

        {{-- CONTROLES --}}
        <div class="col-lg-2">
            <div class="form-group-sm form-group">
                <div class="text-right">
                    <ngShow ng-show="filter_data.filter">
                        <button class="btn-outline btn-rest btn-show" type="submit">
                            <span class="glyphicon glyphicon-ok"></span> Filtrar
                        </button>
                        <button class="btn-outline btn-rest btn-none" type="button" ng-click="filter_active = false; filter_data.filter = filter_data.filtered ? filter_data.filter : null" data-toggle="collapse" data-target="#filter">Cancelar</button>
                    </ngShow>
                </div>
            </div>
        </div>
    </form>
</div>