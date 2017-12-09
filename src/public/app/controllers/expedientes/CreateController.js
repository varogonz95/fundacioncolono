app.controller('Expedientes_CreateController', function($scope, Referente, Ayuda, Region, Typeahead) {

    $scope.formatter = Typeahead.formatter;

    $scope.items = [];

    $scope.cantones = [];
    $scope.distritos = [];
    $scope.estado = $scope.estados[0];

    $scope.datePickers = {
        from: {open: false, date: new Date()},
        to: {open: false, date: null},
    }

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

    // Update Canton SELECT
    $scope.updateCantones = function(p){
        $scope.distritos = [];
        $scope.canton = null;

        Region.cantones(p)
        .then(function(response){ $scope.cantones = Region.parse(response).cantones;});
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function(p, c){
        Region.distritos(p, c)
        .then(function(response){ $scope.distritos = Region.parse(response).distritos; });
    };

    // $scope.validateDate = function(date){
    //     return $scope.estado === 1 ? date : null;
    // };

});
