app.controller('Expedientes_CreateController', function($scope, Persona, Typeahead) {

    $scope.formatter = Typeahead.formatter;

    $scope.items = [];
    $scope.invalid = false;
    $scope.estado = $scope.estados[0];

    $scope.datePickers = {
        from: {open: false, date: new Date()},
        to: {open: false, date: null},
    }

    $scope.validate = function(){
        Persona.get({cedula: $scope.cedula}, function (data) {
            $scope.invalid = !!data.cedula;
		});
    };

    $scope.add = function(){

		$scope.items.push({
			ayuda: $scope.ayuda_selected,
			monto: $scope.monto,
			detalle: $scope.detalle,
		});

		$scope.ayudas.splice(getIndex($scope.ayudas, $scope.ayuda_selected), 1);
		$scope.ayuda_selected = $scope.ayudas[0];

		$scope.monto = null;
		$scope.detalle = null;
	};

	$scope.remove = function(index) {

		//return back item to list
		$scope.ayudas.push($scope.items[index].ayuda);

		// remove item
		$scope.items.splice(index, 1);
	}

});
