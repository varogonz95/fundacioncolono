app.controller('Expedientes_EditController', function ($scope, $filter, Expediente) {
	
	$scope.estado = $scope.estados[0];
	
	$scope.edit = function (){
		copy($scope.selected, $scope.update.caso, ['persona', 'ayudas']);

		$scope.update.caso.estado_selected    = find('id', $scope.update.caso.estado, $scope.estados);
		$scope.update.caso.prioridad_selected = find('id', $scope.update.caso.prioridad, $scope.prioridades);
		$scope.update.caso.referente_selected = $scope.selected.referente.id;
		$scope.update.caso.datePickers = {
			from: {
				date: $scope.update.caso.fecha_desde ? new Date($scope.update.caso.fecha_desde) : new Date(),
				open: false
			},
			to: { 
				date: $scope.update.caso.fecha_hasta ? new Date($scope.update.caso.fecha_hasta) : new Date(),
				open: false 
			}
		} || $scope.update.caso.datePickers;

		$scope.selected.editable = true;
	};

	$scope.commit = function(){

		// Save current state
		$scope.update.cache = $scope.update.cache || angular.copy($scope.selected);

		// parse attributes...
		$scope.update.caso.estado      = $scope.update.caso.estado_selected.id;
		$scope.update.caso.prioridad   = $scope.update.caso.prioridad_selected.id;
		$scope.update.caso.referente   = find('id', $scope.update.caso.referente_selected, $scope.referentes);
		$scope.update.caso.fecha_hasta = $scope.update.caso.datePickers.to.date.toStandardDate();
		$scope.update.caso.fecha_desde = $scope.update.caso.datePickers.from.date.toStandardDate();

        copy($scope.update.caso, $scope.selected, ['fecha_desde', 'fecha_hasta']);
		$scope.selected.fecha_hasta = $filter('date')($scope.update.caso.datePickers.to.date, 'dd-MM-yyyy');
		$scope.selected.fecha_desde = $filter('date')($scope.update.caso.datePickers.from.date, 'dd-MM-yyyy');

		$scope.selected.editable = false;
	};

	$scope.revert = function(){
		copy($scope.update.cache, $scope.selected);

		delete $scope.update.cache;

		$scope.selected.editable = false;
	};

});
