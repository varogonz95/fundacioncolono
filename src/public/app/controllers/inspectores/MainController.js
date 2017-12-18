app.controller('Inspectores_MainController', function($scope, Region) {

	$scope.page = 1;
	$scope.total = 1;

	$scope.activo = [
			{ id: 1, name: 'Sí' },
			{ id: 0, name: 'No' },
	];

	$scope.provincias = Region.provincias();

});
