@extends('partials._modal')

@section('modal-id')
id="recordcreatemodal"
@overwrite

@section('modal-title')
    <h4 class="modal-title">Crear nuevo expediente</h4>
@overwrite

@section('modal-body')
    <form id="recordcreate" class="form-horizontal" name="recordcreate">
        {{ csrf_field() }}
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Descripción del caso:</label>
            <textarea class="form-control" name="descripcion" rows="5"></textarea>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Tipo de ayuda:</label>
            <select class="form-control" name="ayuda">
                <option value="0" disabled>-Seleccionar ayuda-</option>
                <option value="1">Construcción</option>
                <option value="2">Medicamentos</option>
                <option value="3">Equipo médico</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Monto:</label>
            <div class="col-sm-6">
                <input class="form-control" type="text" name="monto" placeholder="Monto" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Meses asignados:</label>
            <div class="col-sm-3">
                <input class="form-control" type="number" name="meses" min="1" value="1" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Prioridad:</label>
            <div class="col-sm-6">
                <select class="form-control" name="prioridad">
                    <option value="0" disabled>-Seleccionar prioridad-</option>
                    <option value="3">Alta (3)</option>
                    <option value="2">Media (2)</option>
                    <option value="1">Baja (1)</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Estado de aprobación:</label>
            <span class="glyphicon glyphicon-info-sign text-info"></span>
            <div class="col-sm-6">
                <select class="form-control" name="estado">
                    <option value="" disabled>-Seleccionar estado-</option>
                    <option value="0">Aplica</option>
                    <option value="1">No aplica</option>
                    <option value="2">En valoración</option>
                </select>
            </div>
        </div>
        <div class="form-group col-sm-10 col-sm-push-1">
            <label>Recomendaciones:</label>
            <textarea class="form-control" name="recomendaciones" rows="5"></textarea>
        </div>
    </form>
@overwrite

@section('modal-footer')
    <footer class="modal-footer">
        <button type="button" class="center-block btn btn-primary" ng-click="save(false)">Guardar y crear expediente</button>
    </footer>
@overwrite
