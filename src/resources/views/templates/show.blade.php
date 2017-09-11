<!--
Cosas que se pueden hacer:

    1) Cambiar los datos de la persona
    2) Cambiar los datos del expediente
        2.1) Cuando se cambia el estado a aprobado, se pueden asignar lo meses de ayuda (que a su vez se pueden modificar)
    3) Eliminar ayudas
        3.1) No se permiten ayudas repetidas
        3.2) Solo se permite un mínimo de 1 ayuda relacionada
    4) Cambiar las recomendaciones de las ayudas
    5) Eliminar completamente el expediente
-->


<div id="show_modal" class="animated">

    <header class="animatedModal-header">
        <button type="button" class="btn btn-sm btn-default close-animatedModal"><span class="glyphicon glyphicon-remove"></span>Cerrar</button>
        <button type="button" class="btn btn-sm btn-danger close-animatedModal">Eliminar <span class="glyphicon glyphicon-trash"></span></button>
    </header>

    <section class="animatedModal-content expediente-content" style="padding:0 1em">

        <!-- DATOS DE LA PERSONA -->
        <article class="col-md-4 @{{ (selected.persona.editable)? 'editing' : '' }}">
            <header class="page-header">
                <h3>Datos de la persona <small class="nowrap">@{{ (selected.persona.editable)? '(en edición)' : '' }}</small></h3>
            </header>

            <section class="expediente-info">

                <button type="button" class="btn-rest btn-edit btn-sm" ng-click="edit('p')" ng-hide="selected.persona.editable"><span class="glyphicon glyphicon-pencil"></span> Editar</button>

                <div class="controls" ng-show="selected.persona.editable">
                    <button type="button" class="btn-rest btn-show" ng-click="update('p')"><span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                    <button type="button" class="close" title="Cancelar edición" ng-click="selected.persona.editable = false">&times;</button>
                </div>

                <div class="expediente-info-item">
                    <label>Cédula: </label>
                    <span ng-hide="selected.persona.editable">@{{ selected.persona.cedula }}</span>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <input class="form-control" type="text" name="cedula" value="@{{ selected.persona.cedula }}">
                    </div>
                </div>

                <div class="expediente-info-item">
                    <div ng-hide="selected.persona.editable">
                        <label>Nombre completo: </label>
                        <span ng-hide="selected.persona.editable">@{{ selected.persona.nombre + ' ' + selected.persona.apellidos }}</span>
                    </div>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <label>Nombre: </label>
                        <input class="form-control" type="text" name="nombre" value="@{{ selected.persona.nombre }}">
                    </div>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <label>Apellidos: </label>
                        <input class="form-control" type="text" name="apellidos" value="@{{ selected.persona.apellidos }}">
                    </div>
                </div>

                <div class="expediente-info-item">
                    <label>Teléfono(s): </label>
                    <span ng-hide="selected.persona.editable">@{{ selected.persona.telefonos }}</span>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <textarea name="tels" class="noresize form-control" rows="5" cols="50" placeholder="Separe por comas (,) o espacios">@{{ selected.persona.telefonos }}</textarea>
                    </div>
                </div>

                <div class="expediente-info-item">
                    <label>Ubicación: </label>
                    <span ng-hide="selected.persona.editable">@{{ selected.persona.ubicacion }}</span>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <p class="help-block">Provincia:</p>
                        <select class="form-control" name="provincia">
                            <option value="" selected disabled>-Seleccionar provincia-</option>
                            <option value="1">San Jośe</option>
                            <option value="2">Cartago</option>
                            <option value="3">Alajuela</option>
                            <option value="4">Heredia</option>
                        </select>

                        <p class="help-block">Cantón:</p>
                        <select class="form-control" name="canton">
                            <option value="" selected disabled>-Seleccionar distrito-</option>
                        </select>

                        <p class="help-block">Distrito:</p>
                        <select class="form-control" name="distrito">
                            <option value="" selected disabled>-Seleccionar cantón-</option>
                        </select>
                    </div>
                </div>

                <div class="expediente-info-item">
                    <label>Dirección exacta: </label>
                    <p ng-hide="selected.persona.editable">@{{ selected.persona.direccion }}</p>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <textarea name="direccion" class="noresize form-control" rows="5" cols="50" placeholder="">@{{ selected.persona.direccion }}</textarea>
                    </div>
                </div>

                <div class="expediente-info-item">
                    <label>Contacto(s): </label>
                    <p ng-hide="selected.persona.editable">@{{ selected.persona.contactos }}</p>
                    <div class="form-group" ng-if="selected.persona.editable">
                        <textarea name="contactos" class="noresize form-control" rows="5" cols="50" placeholder="">@{{ selected.persona.contactos }}</textarea>
                    </div>
                </div>

            </section>
        </article>

        <!-- INFORMACION DEL EXPEDIENTE -->
        <article class="col-md-4 @{{ (selected.editable)? 'editing' : '' }}">
            <header class="page-header">
                <h3>Detalles del caso <small class="nowrap">@{{ (selected.editable)? '(en edición)' : '' }}</small></h3>
            </header>

          <section class="expediente-info">

              <button type="button" class="btn-rest btn-edit btn-sm" ng-click="edit('e')" ng-hide="selected.editable"><span class="glyphicon glyphicon-pencil"></span> Editar</button>

              <div class="controls" ng-show="selected.editable">
                  <button type="button" class="btn-rest btn-show" ng-click="update('e')"><span class="glyphicon glyphicon-ok"></span> Aceptar cambios</button>
                  <button type="button" class="close" title="Cancelar edición" ng-click="selected.editable = false">&times;</button>
              </div>

              <div class="expediente-info-item">
                  <label>Descripción: </label>
                  <p ng-hide="selected.editable">@{{ selected.descripcion }}</p>
                  <div class="form-group" ng-if="selected.editable">
                      <textarea name="contactos" class="noresize form-control" rows="5" cols="50" placeholder="">@{{ selected.descripcion }}</textarea>
                  </div>
              </div>

              <div class="expediente-info-item">
                  <label>Referente: </label>
                  <span ng-hide="selected.editable">@{{ (selected.referente.id === 1)? selected.referente_otro : selected.referente.descripcion }}</span>
                  <div class="form-group" ng-if="selected.editable">
                      {{-- <input type="text" name="refere" value=""> --}}
                      <label style="font-weight:100">Otro referente: <input type="checkbox" name="hasReferenteOtro" ng-checked="selected.referente_otro !== null" ng-model="selected.hasReferenteOtro" ng-init="selected.hasReferenteOtro = selected.referente_otro !== null"></label>
                      <input class="form-control" type="text" name="referente_otro" placeholder="Nombre del referente o institución" value="@{{ selected.referente_otro }}" ng-show="selected.hasReferenteOtro">
                      <label style="font-weight:100;font-size:12px;text-indent:1.5em;" ng-show="selected.hasReferenteOtro">Agregar a opciones: <input type="checkbox" name="newReferente"></label>
                      <select class="form-control" name="referente" ng-if="!selected.hasReferenteOtro">
                          @foreach (\App\Models\Referente::where('id', '<>', 1)->get() as $r)
                              <option value="{{ $r->id }}" ng-selected="selected.referente.id === {{ $r->id }}">{{ $r->descripcion }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="expediente-info-item">
                  <label>Prioridad: </label>
                  <span ng-hide="selected.editable">@{{ (selected.prioridad === 1)? 'Baja' : (selected.prioridad === 2)? 'Media' : (selected.prioridad === 3)? 'Alta' : '' }}</span>
                  <div class="form-group" ng-if="selected.editable">
                      <select class="form-control" name="prioridad">
                          <option value="1" ng-selected="selected.prioridad === 1">Baja</option>
                          <option value="2" ng-selected="selected.prioridad === 2">Media</option>
                          <option value="3" ng-selected="selected.prioridad === 3">Alta</option>
                      </select>
                  </div>
              </div>

              <div class="expediente-info-item">
                  <label>Estado de aprobación: </label>
                  <span ng-hide="selected.editable">@{{ (selected.estado === 0)? 'En valoración' : (selected.estado === 1)? 'Aprobado' : (selected.estado === 2)? 'No aprobado' : '' }}</span>
                  <div class="form-group" ng-if="selected.editable">
                      <select class="form-control" name="estado">
                          <option value="0" ng-selected="selected.estado === 0">En valoración (por defecto)</option>
                          <option value="1" ng-selected="selected.estado === 1">Aprobado</option>
                          <option value="2" ng-selected="selected.estado === 2">No aprobado</option>
                      </select>
                  </div>
                  <p class="help-block"><small>Para mostrar el campo de <strong>meses asignados</strong>, el expediente debe estar <u>Aprobado</u>.</small></p>
              </div>

          </section>

        </article>

    </section>

</div>
