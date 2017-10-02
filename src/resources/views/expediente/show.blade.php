
@component('components.animatedModal')
    @slot('id')
        show_modal
    @endslot

    @slot('header_content')
        <button type="button" class="btn btn-sm btn-default close-animatedModal"><span class="glyphicon glyphicon-remove"></span>Cerrar</button>
        <button type="button" class="btn btn-sm btn-danger" ng-click="delete(selected)">Eliminar <span class="glyphicon glyphicon-trash"></span></button>
    @endslot

    @slot('content_classes')
        expediente-content
    @endslot

    <!-- DATOS DE LA PERSONA -->
    <article id="selectedpersona" class="col-md-4 col-md-offset-1 @{{ (selected.persona.editable)? 'editing' : '' }}">
        <header class="page-header">
            <h3>
                Datos de la persona
                <small>@{{ (selected.persona.editable)? '(en edición)' : '' }}</small>
            </h3>
        </header>

        <section class="expediente-info">

            <button type="button" class="btn-rest btn-edit btn-sm" ng-click="edit('p')" ng-hide="selected.persona.editable"><span class="glyphicon glyphicon-pencil"></span> Editar</button>

            <div class="controls" ng-show="selected.persona.editable">
                <button type="button" class="btn-rest btn-show" ng-click="updatePersona(update.persona)"><span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                <button type="button" class="close" title="Cancelar edición" ng-click="selected.persona.editable = false">&times;</button>
            </div>

            <div class="expediente-info-item">
                <label>Cédula: </label>
                <span ng-hide="selected.persona.editable">@{{ selected.persona.cedula }}</span>
                <div class="form-group" ng-if="selected.persona.editable">
                    <input class="form-control" type="text" name="cedula" value="@{{ selected.persona.cedula }}" ng-model="update.persona.cedula">
                </div>
            </div>

            <div class="expediente-info-item">
                <div ng-hide="selected.persona.editable">
                    <label>Nombre completo: </label>
                    <span ng-hide="selected.persona.editable">@{{ selected.persona.nombre + ' ' + selected.persona.apellidos }}</span>
                </div>
                <div class="form-group" ng-if="selected.persona.editable">
                    <label>Nombre: </label>
                    <input class="form-control" type="text" name="nombre" value="@{{ selected.persona.nombre }}" ng-model="update.persona.nombre">
                </div>
                <div class="form-group" ng-if="selected.persona.editable">
                    <label>Apellidos: </label>
                    <input class="form-control" type="text" name="apellidos" value="@{{ selected.persona.apellidos }}" ng-model="update.persona.apellidos">
                </div>
            </div>

            <div class="expediente-info-item">
                <label>Teléfono(s): </label>
                <span ng-hide="selected.persona.editable">@{{ selected.persona.telefonos }}</span>
                <div class="form-group" ng-if="selected.persona.editable">
                    <textarea name="telefonos" class="noresize form-control" rows="5" cols="50" placeholder="Separe por comas (,) o espacios" ng-model="update.persona.telefonos">@{{ selected.persona.telefonos }}</textarea>
                </div>
            </div>

            <div class="expediente-info-item">
                <label>Ubicación: </label>
                <span ng-hide="selected.persona.editable">
                    @{{
                        selected.persona.provincia.name + ', '
                        + selected.persona.canton.name + ', '
                        + selected.persona.distrito.name
                    }}
                </span>
                <div class="form-group" ng-if="selected.persona.editable">
                    <p class="help-block">Provincia:</p>
                    <select class="form-control" name="provincia" ng-model="update.persona.provincia" ng-options="p as p.name for p in provincias track by p.cod" ng-change="updateCantones(update.persona.provincia.cod)" convert-to-number>
                        <option value="" disabled>-Seleccionar provincia-</option>
                    </select>
                    <p class="help-block">Cantón</p>
                    <select class="form-control" name="canton" ng-model="update.persona.canton" ng-options="c as c.name for c in cantones track by c.cod" ng-change="updateDistritos(update.persona.provincia.cod, update.persona.canton.cod)" ng-disabled="cantones.length === 0" convert-to-number>
                        <option value="" disabled>-Seleccionar cantón-</option>
                    </select>
                    <p class="help-block">Distrito</p>
                    <select class="form-control" name="distrito" ng-model="update.persona.distrito" ng-options="d as d.name for d in distritos track by d.cod" ng-disabled="distritos.length === 0" convert-to-number>
                        <option value="" disabled>-Seleccionar distrito-</option>
                    </select>
                </div>
            </div>

            <div class="expediente-info-item">
                <label>Dirección exacta: </label>
                <p ng-hide="selected.persona.editable">@{{ selected.persona.direccion }}</p>
                <div class="form-group" ng-if="selected.persona.editable">
                    <textarea name="direccion" class="noresize form-control" rows="5" cols="50" placeholder="" ng-model="update.persona.direccion">@{{ selected.persona.direccion }}</textarea>
                </div>
            </div>

            <div class="expediente-info-item">
                <label>Contacto(s): </label>
                <p ng-hide="selected.persona.editable">@{{ selected.persona.contactos }}</p>
                <div class="form-group" ng-if="selected.persona.editable">
                    <textarea name="contactos" class="noresize form-control" rows="5" cols="50" placeholder="" ng-model="update.persona.contactos">@{{ selected.persona.contactos }}</textarea>
                </div>
            </div>

        </section>
    </article>

    <!-- INFORMACION DEL EXPEDIENTE -->
    <article id="selectedexpediente" class="col-md-4 col-md-offset-1 @{{ (selected.editable)? 'editing' : '' }}">
            <header class="page-header">
              <h3>
                  Detalles del caso
                  <small>
                      @{{ (selected.editable)? '(en edición)' : '' }}
                  </small>
              </h3>
          </header>

          <section class="expediente-info">

              <button type="button" class="btn-rest btn-edit btn-sm" ng-click="edit('e')" ng-hide="selected.editable"><span class="glyphicon glyphicon-pencil"></span> Editar</button>

              <div class="controls" ng-show="selected.editable">
                  <button type="button" class="btn-rest btn-show" ng-click="updateCaso(update.caso)"><span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                  <button type="button" class="close" title="Cancelar edición" ng-click="selected.editable = false">&times;</button>
              </div>

              <div class="expediente-info-item">
                  <label>Descripción: </label>
                  <p ng-hide="selected.editable">@{{ selected.descripcion }}</p>
                  <div class="form-group" ng-if="selected.editable">
                      <textarea name="descripcion" class="noresize form-control" rows="5" cols="50" placeholder="" ng-model="update.caso.descripcion">@{{ selected.descripcion }}</textarea>
                  </div>
              </div>

              <div class="expediente-info-item">
                  <label>Referente: </label>
                  <span ng-hide="selected.editable">@{{ (selected.referente.id === 1)? selected.referente_otro : selected.referente.descripcion }}</span>
                  <div class="form-group" ng-if="selected.editable">
                      <label style="font-weight:100">Otro referente: <input type="checkbox" name="hasReferenteOtro" ng-checked="selected.referente_otro !== null" ng-model="selected.hasReferenteOtro" ng-init="selected.hasReferenteOtro = selected.referente_otro !== null"></label>
                      <input class="form-control" type="text" name="referente_otro" placeholder="Referente" ng-model="update.caso.referente_otro" value="@{{ selected.referente_otro }}" ng-show="selected.hasReferenteOtro">
                      <label style="font-weight:100;font-size:12px;text-indent:1.5em;" ng-show="selected.hasReferenteOtro">Agregar a opciones: <input type="checkbox" name="newReferente"></label>
                      <select class="form-control" name="referente" ng-if="!selected.hasReferenteOtro" ng-model="referente_selected" ng-options="r.descripcion for r in referentes track by r.id"></select>
                      <!-- <input type="text" name="referente" placeholder="-Seleccione un referente-" autocomplete="off" ng-model="referente_selected" uib-typeahead="r.id as r.descripcion for r in referentes | filter:$viewValue | limitTo:20" class="form-control" typeahead-show-hint="true" typeahead-min-length="0" typeahead-append-to="null" typeahead-input-formatter="formatter($model, referentes, 'id', 'descripcion')"> -->
                  </div>
              </div>

              <div class="expediente-info-item">
                  <label>Prioridad: </label>
                  <span class="label label-@{{ (selected.prioridad === 1)? 'info' : (selected.prioridad === 2)? 'warning' : (selected.prioridad === 3)? 'danger' : '' }}" ng-hide="selected.editable">
                      @{{ (selected.prioridad === 1)? 'Baja' : (selected.prioridad === 2)? 'Media' : (selected.prioridad === 3)? 'Alta' : '' }}
                    </span>
                  <div class="form-group" ng-if="selected.editable">
                      <select class="form-control" name="prioridad" ng-model="prioridad_selected" ng-options="o.name for o in prioridades track by o.id" convert-to-number></select>
                  </div>
              </div>

              <div class="expediente-info-item">
                  <label>Estado de aprobación: </label>
                  <span class="label label-@{{ (selected.estado === 0)? 'info' : (selected.estado === 1)? 'success' : (selected.estado === 2)? 'danger' : '' }}" ng-hide="selected.editable">@{{ (selected.estado === 0)? 'En valoración' : (selected.estado === 1)? 'Aprobado' : (selected.estado === 2)? 'No aprobado' : '' }}</span>
                  <div class="form-group" ng-if="selected.editable">
                      <select class="form-control" name="estado" ng-model="estado_selected" ng-options="o.name for o in estados track by o.id" convert-to-number></select>
                  </div>
                  <p class="help-block" ng-show="selected.estado !== 1"><small>Para mostrar el campo de <strong>meses asignados</strong>, el expediente debe estar <u>Aprobado</u>.</small></p>
              </div>

              <div class="expediente-info-item" ng-if="selected.estado === 1">
                  <label>Validez</label>
                  <p ng-hide="selected.editable" style="padding: 0 10px">
                      Desde: @{{ selected.pago_inicio }}<br>
                      Hasta: @{{ selected.pago_final }}<br>
                      <small class="help-block">Número de meses: </small>
                  </p>
                  {{-- <div class="form-group" ng-if="selected.editable">
                      <select class="form-control" name="estado" ng-model="estado_selected" ng-options="o.name for o in estados track by o.id" convert-to-number></select>
                  </div> --}}
              </div>

          </section>

        </article>


    {{-- INFORMACION DE LAS AYUDAS --}}
    <article id="selectedayuda" class="col-md-8 col-md-offset-2">

        <header class="page-header">
          <h3>
              Ayudas solicitadas
              <small>
                  @{{ (selected.editable)? '(en edición)' : '' }}
              </small>
          </h3>
      </header>

      <section class="expediente-info" ng-repeat="ayuda in selected.ayudas">

          <span>Tipo de ayuda:</span><br>
          <p>@{{ ayuda.descripcion }}</p>
          <span>Monto:</span><br>
          <p>@{{ ayuda.pivot.monto }}</p>
          <span>Descripcion:</span><br>
          <p>@{{ ayuda.pivot.detalle }}</p>

          <span></span>

      </section>

    </article>

@endcomponent
