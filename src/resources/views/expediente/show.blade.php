<article id="selectedexpediente" class="col-md-4 col-md-offset-1 @{{ (selected.editable)? 'editing' : '' }}" ng-controller="Expedientes_EditController">
    <header>
        <h3>
            Detalles del caso
            <small>
                @{{ (selected.editable)? '(en edición)' : '' }}
            </small>
        </h3>
        <hr>
    </header>

    <section class="expediente-info form-horizontal" ng-if="selected.editable" style="overflow-y: auto">
        <div class="controls" ng-show="selected.editable">
            <button type="button" class="btn-rest btn-outline btn-show" ng-click="updateCaso(update.caso)">
                <span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
            <button type="button" class="close" title="Cancelar edición" ng-click="selected.editable = false">&times;</button>
        </div>

        {{-- INCLUDE EXPEDIENTE FORM COMPONENT --}}
        @include('expediente.$edit')
    </section>

    <section class="expediente-info" ng-hide="selected.editable">

        <button type="button" class="btn-outline btn-rest btn-edit btn-sm" ng-click="edit()">
            <span class="glyphicon glyphicon-pencil"></span> 
            Editar
        </button>

        <div class="expediente-info-item">
            <label>Descripción: </label>
            <p>@{{ selected.descripcion }}</p>
        </div>

        <div class="expediente-info-item">
            <label>Referente: </label>
            <span>@{{ (selected.referente.id === 1)? selected.referente_otro : selected.referente.descripcion }}</span>
        </div>

        <div class="expediente-info-item">
            <label>Prioridad: </label>
            <span class="label label-@{{ (selected.prioridad === 1)? 'info' : (selected.prioridad === 2)? 'warning' : (selected.prioridad === 3)? 'danger' : '' }}">
                @{{ (selected.prioridad === 1)? 'Baja' : (selected.prioridad === 2)? 'Media' : (selected.prioridad === 3)? 'Alta' : '' }}
            </span>
        </div>

        <div class="expediente-info-item">
            <label>Estado de aprobación: </label>
            <br class="visible-xs">
            <span class="label label-@{{ (selected.estado === 0)? 'info' : (selected.estado === 1)? 'success' : (selected.estado === 2)? 'danger' : '' }}">
                @{{ (selected.estado === 0)? 'En valoración' : (selected.estado === 1)? 'Aprobado' : (selected.estado === 2)?'No aprobado' : '' }}
            </span>
            {{-- <p class="help-block" ng-show="selected.estado !== 1">
                <small>Para mostrar el campo de
                    <strong>meses asignados</strong>, el expediente debe estar
                    <u>Aprobado</u>.</small>
            </p> --}}
        </div>

        <div class="expediente-info-item" ng-show="selected.estado === 1">
            <label>Validez</label>
            <p style="padding: 0 10px">
                Desde: @{{ selected.pago_inicio }}
                <br> Hasta: @{{ selected.pago_final }}
                <br>
                <small class="help-block">Número de meses: </small>
            </p>
        </div>

    </section>

</article>