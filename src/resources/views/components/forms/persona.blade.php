<!-- CEDULA -->
<div class="form-group{{-- @{{ newexpediente.cedula.$invalid && newexpediente.cedula.$dirty? 'has-error' : '' }} --}}">
    <label class="control-label col-md-3" for="cedula">Cédula:</label>
    <div class="col-md-8 col-md-push-1">
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
    <label class="text-right col-md-3" for="apellidos">Teléfono(s):</label>
    <div class="col-md-8 col-md-push-1">
        <textarea name="telefonos" class="noresize form-control" rows="5" cols="50" placeholder="Separe por comas (,) o espacios" ng-model="{{ $telefonos_model }}">
            {{ $telefonos_value }}
        </textarea>
    </div>
</div>

<!-- UBICACION -->
{{-- THIS NEEDS TO BE CHANGED TO A DIRECTIVE --}}
<div class="form-group">
    <label class="text-right col-md-3" for="ubicacion">Ubicación:</label>
    <div class="col-md-8 col-md-offset-1">
        <p class="help-block">Provincia</p>
        <select class="form-control" name="provincia" ng-model="{{ $provincia_model }}" ng-options="{{ $provincia_options_expression }}" ng-change="{{ $provincia_onchanged_handler }}" required>
            <option value="" disabled>-Seleccionar provincia-</option>
        </select>
        <p class="help-block">Cantón</p>
        <select class="form-control" name="canton" ng-model="{{ $canton_model }}" ng-options="{{ $canton_options_expression }}" ng-change="{{ $canton_onchanged_handler }}" ng-disabled="{{ $canton_list }}.length === 0" required>
            <option value="" disabled>-Seleccionar cantón-</option>
        </select>
        <p class="help-block">Distrito</p>
        <select class="form-control" name="distrito" ng-model="{{ $distrito_model }}" ng-options="{{ $distrito_options_expression }}" ng-disabled="{{ $distrito_list }}.length === 0" required>
            <option value="" disabled>-Seleccionar distrito-</option>
        </select>
    </div>
</div>

<!-- DIRECCION EXACTA -->
<div class="form-group">
    <label class="col-sm-3" for="direccion">Dirección exacta:</label>
    <div class="col-sm-12">
        <textarea name="direccion" class="noresize form-control" rows="5" cols="50" ng-model="{{ $direccion_model }}" required>
            {{ $direccion_value }}
        </textarea>
    </div>
</div>

<!-- CONTACTOS -->
<div class="form-group">
    <label class="col-sm-2" for="contactos">Contacto(s):</label>
    <div class="col-sm-12">
        <textarea name="contactos" class="noresize form-control" rows="5" cols="50" ng-model="{{ $contactos_model }}">
            {{ $contactos_value }}
        </textarea>
    </div>
</div>
