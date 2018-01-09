<!-- CEDULA -->
<div class="form-group" {{-- ng-class="{'has-error': newexpediente.cedula.$invalid && newexpediente.cedula.$dirty}"--}}>
    <label class="control-label col-md-1" for="cedula">Cédula:</label>
    <div class="col-md-8 col-md-push-3">
        <input type="text" class="form-control" name="cedula" placeholder="Formato: x0xxx0xxx" ng-model="{{ $cedula_model }}" ng-value="{{ $cedula_value }}" required>
        {{ $cedula_help }}
    </div>
</div>

<!-- NOMBRE -->
<div class="form-group">
    <label class="control-label col-md-3" for="nombre">Nombre:</label>
    <div class="col-md-8 col-md-push-1">
        <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre" ng-model="{{ $nombre_model }}" ng-value="{{ $nombre_value }}" required>
    </div>
</div>

<!-- APELLIDOS -->
<div class="form-group">
    <label class="control-label col-md-3" for="apellidos">Apellidos:</label>
    <div class="col-md-8 col-md-push-1">
        <input type="text" class="form-control" name="apellidos" placeholder="Ingrese los apellidos" ng-model="{{ $apellidos_model }}" ng-value="{{ $apellidos_value }}" required>
    </div>
</div>

<!-- TELEFONOS -->
<div class="form-group">
    <label class="control-label col-md-3" for="telefonos">Teléfono(s):</label>
    <div class="col-md-8 col-md-push-1">
        <textarea name="telefonos" class="noresize form-control" rows="5" cols="50" placeholder="Separe por comas (,) o espacios" ng-model="{{ $telefonos_model }}">
        </textarea>
    </div>
</div>

<!-- UBICACION -->
{{-- THIS NEEDS TO BE CHANGED TO A DIRECTIVE --}}
<div class="form-group">
    <label class="control-label col-md-3" for="ubicacion">Ubicación:</label>
    <region-select {{ isset($ubicacion_options) ? $ubicacion_options : '' }}></region-select>
</div>

<!-- DIRECCION EXACTA -->
<div class="form-group">
    <label class="control-label col-md-3" for="direccion" style="width:150px">Dirección exacta:</label>
    <div class="col-md-8 col-md-push-1">
        <textarea name="direccion" class="noresize form-control" rows="5" cols="50" ng-model="{{ $direccion_model }}" required>
        </textarea>
    </div>
</div>

<!-- CONTACTOS -->
<div class="form-group">
    <label class="control-label col-sm-3" for="contactos">Contacto(s):</label>
    <div class="col-md-8 col-md-push-1">
        <textarea name="contactos" class="noresize form-control" rows="5" cols="50" ng-model="{{ $contactos_model }}">
        </textarea>
    </div>
</div>
