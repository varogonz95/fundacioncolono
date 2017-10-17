
<div class="form-group">
    @if($isAttach)
        <label>Tipo de ayuda</label>
        <select class="form-control" ng-model="{{ $ayuda_model }}" ng-options="{{ $ayuda_options_expression }}"></select>
    @else
        <label>Tipo de ayuda:</label>
        <h5 class="lead">@{{ {!!$descripcion_value!!} }}</h5>
    @endif
</div>

<div class="form-group">
    <label class="">Detalle:</label>
    <textarea name="" class="form-control noresize" cols="50" rows="5" ng-model="{{ $detalle_model }}">@{{ {!!$detalle_value!!} }}</textarea>
</div>

<div class="form-group">
    <label class="">Monto: </label>
    <input type="text" name="" class="form-control" ng-model="{{ $monto_model }}" ng-value="{{ $monto_value }}">
</div>