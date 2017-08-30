<div class="col-md-6 col-md-push-3">
    <form id="personcreate" class="form-horizontal" name="personcreate">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="checkbox-inline col-sm-push-6"><input type="checkbox" name="withrecord" ng-model="withrecord" value="@{{withrecord}}"> Crear expediente</label>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Identificación:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="cedula" placeholder="No. de Identificación" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Nombre:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="nombre" placeholder="Ingrese el nombre" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Apellidos:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="apellidos" placeholder="Ingrese los apellidos">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Ocupación:</label>
            <div class="col-sm-7">
                <input class="form-control" type="text" name="ocupacion" placeholder="Ingrese la ocupación">
            </div>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Número(s) de teléfono:</label>
            <textarea class="form-control" name="tels" rows="3"></textarea>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Ubicación:</label>
            <p class="help-block">Provincia</p>
            <select class="form-control" name="provincia" ng-model="provincia" ng-change="location.select(provincia,0,this)">
                <option value="0" disabled>-Seleccionar provincia-</option>
                <option value="1">San José</option>
                <option value="2">Alajuela</option>
                <option value="3">Cartago</option>
                <option value="4">Heredia</option>
                <option value="5">Guanacaste</option>
                <option value="6">Puntarenas</option>
                <option value="7">Limón</option>
            </select>
            <p class="help-block">Cantón</p>
            <select class="form-control" name="canton" ng-disabled="cantones.length === 0" ng-model="canton" ng-change="location.select(provincia,canton,this)">
                <option value="0">-Seleccionar cantón-</option>
                <option value="@{{ $index + 1 }}" ng-repeat="c in cantones | limitTo: (1 - cantones.length) ">@{{ c }}</option>
            </select>
            <p class="help-block">Distrito</p>
            <select class="form-control" name="distrito" ng-disabled="distritos.length === 0" ng-model="distrito">
                <option value="0">-Seleccionar distrito-</option>
                <option value="@{{ $index + 1 }}" ng-repeat="d in distritos | limitTo: (1 - distritos.length) ">@{{ d }}</option>
            </select>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Dirección exacta:</label>
            <textarea class="form-control" name="direccion" rows="5"></textarea>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Contacto(s):</label>
            <textarea class="form-control" name="contactos" rows="5"></textarea>
        </div>
    </form>
</div>
@include('templates.records.create')
