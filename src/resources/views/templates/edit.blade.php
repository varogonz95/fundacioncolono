<div class="col-md-10 col-md-offset-1">
    <form id="personaupdate" class="form-horizontal" action="{{ route('personas.update') }}" method="put">

        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label col-sm-2" for="cedula">Cédula:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cedula" placeholder="Formato: x0xxx0xxx">
                <p class="help-block"><small>Reemplace las equis (x) por los números de la cédula correspondiente</small></p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="nombre">Nombre:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="apellidos">Apellidos:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="apellidos" placeholder="Ingrese los apellidos">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="apellidos">Teléfono(s):</label>
            <div class="col-sm-10 col-sm-offset-2">
                <textarea name="tels" class="noresize form-control" rows="5" cols="50" placeholder="Separe por comas (,) o espacios"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="ubicacion">Ubicación:</label>
            <div class="col-sm-10 col-sm-offset-2">
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
        </div>

        <div class="form-group">
            <label class="col-sm-12" for="direccion">Dirección exacta:</label>
            <div class="col-sm-10 col-sm-offset-2">
                <textarea name="direccion" class="noresize form-control" rows="5" cols="50"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="contactos">Contacto(s):</label>
            <div class="col-sm-10 col-sm-offset-2">
                <textarea name="contactos" class="noresize form-control" rows="5" cols="50"></textarea>
            </div>
        </div>
        
    </form>
</div>
