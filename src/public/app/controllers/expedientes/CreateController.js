app.controller('Expedientes_CreateController', function($scope, Persona) {

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

	$scope.remove = function(index) {

		//return back item to list
		$scope.ayudas.push({id: $scope.items[index].id, descripcion: $scope.items[index].descripcion});

		// remove item
		$scope.items.splice(index, 1);
	};
});
