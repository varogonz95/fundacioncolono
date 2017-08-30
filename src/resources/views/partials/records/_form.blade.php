@if(Route::getCurrentRoute()->uri=='records/edit')
    <form id="recordupdate" class="form-horizontal" name="recordupdate">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label col-sm-3">Identificación:</label>
            <div class="col-sm-7">
                <span ng-show="@{{!!persona.selected.cedula}}" style="color:#DC5353;font-size:12px"><span class="glyphicon glyphicon-asterisk"></span> Este campo no es editable</span>
                <input class="form-control" type="text" name="cedula" placeholder="No. de Identificación" ng-model="persona.selected.cedula" value="@{{persona.selected.cedula}}" ng-disabled="@{{!!persona.selected.cedula}}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Nombre:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="nombre" placeholder="Ingrese el nombre" ng-model="persona.selected.nombre" value="@{{persona.selected.nombre}}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Apellidos:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="apellidos" placeholder="Ingrese los apellidos" value="@{{persona.selected.apellidos}}" ng-model="persona.selected.apellidos">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Ocupación:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="ocupacion" placeholder="Ingrese la ocupación" value="@{{persona.selected.ocupacion}}" ng-model="persona.selected.ocupacion">
            </div>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Número(s) de teléfono:</label>
            <textarea class="form-control" name="tels" rows="3" ng-model="persona.selected.tels">@{{persona.selected.tels}}</textarea>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Ubicación:</label>
            <p class="help-block">Provincia</p>
            <select class="form-control" name="provincia">
                <option value="0">-Seleccionar provincia-</option>
                <option value="1">San José</option>
                <option value="2">Alajuela</option>
                <option value="3">Cartago</option>
                <option value="4">Heredia</option>
                <option value="5">Guanacaste</option>
                <option value="6">Puntarenas</option>
                <option value="7">Limón</option>
            </select>
            <p class="help-block">Cantón</p>
            <select class="form-control" name="canton" disabled>
                <option value="0">-Seleccionar cantón-</option>
            </select>
            <p class="help-block">Distrito</p>
            <select class="form-control" name="distrito" disabled>
                <option value="0">-Seleccionar distrito-</option>
            </select>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Dirección exacta:</label>
            <textarea class="form-control" name="direccion" rows="5" ng-model="persona.selected.direccion">@{{persona.selected.direccion}}</textarea>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Contacto(s):</label>
            <textarea class="form-control" name="contacto" rows="5"></textarea>
        </div>
    </form>

@elseif(Route::getCurrentRoute()->uri=='records/create')
    <form id="recordcreate" class="form-horizontal" name="recordcreate">
        {{ csrf_field() }}
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Descripción del caso:</label>
            <textarea class="form-control" name="descripcion" rows="5"></textarea>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Tipo de ayuda:</label>
            <select class="form-control" name="ayuda">
                <option value="0">-Seleccionar ayuda-</option>
                <option value="2">Construcción</option>
                <option value="1">Medicamentos</option>
                <option value="1">Equipo médico</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Monto asignado:</label>
            <div class="col-sm-6">
                <input class="form-control" type="text" name="monto" placeholder="Monto" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Prioridad:</label>
            <div class="col-sm-6">
                <select class="form-control" name="prioridad">
                    <option value="0">-Seleccionar prioridad-</option>
                    <option value="3">Alta (3)</option>
                    <option value="2">Media (2)</option>
                    <option value="1">Baja (1)</option>
                </select>
            </div>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Recomendaciones:</label>
            <textarea class="form-control" name="recomendaciones" rows="5"></textarea>
        </div>
    </form>
@endif
