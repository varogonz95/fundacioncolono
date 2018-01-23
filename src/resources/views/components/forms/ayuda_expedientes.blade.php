<div class="form-horizontal">
	<div class="form-group">
		<label class="col-md-6">Tipo de ayuda:</label>
		<h5 class="lead col-md-12" ng-bind="{{ $descripcion_value }}"></h5>
	</div>

	<div class="form-group">
		<label class="col-md-3">Detalle:</label>
		<div class="col-md-12">
			<textarea name="" class="form-control noresize" cols="50" rows="5" ng-model="{{ $detalle_model }}">{{ $detalle_value }}</textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-2 text-nowrap">Monto:</label>
		<div class="col-md-4">
			<input type="text" name="" class="form-control" ng-model="{{ $monto_model }}" ng-value="{{ $monto_value }}">
		</div>
	</div>
</div>