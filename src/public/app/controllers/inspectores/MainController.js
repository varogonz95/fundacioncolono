app.controller('Inspectores_MainController', function($scope, Region) {

	$scope.selected = {};

	$scope.page = 1;
	$scope.total = 1;

	$scope.update = {
			persona: {},
			usuario: {},
	};

	$scope.provincias = Region.provincias();

});
