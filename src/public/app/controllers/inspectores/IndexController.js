app.controller('Inspectores_IndexController', function($scope, Inspector) {
	
	$scope.inspectores = [];

	$scope.index = function (page = 1){

		console.log('Hola Index');

		$scope.page = (page < 1) ? 1 : page;

		Inspector('all').get(
			{page: page},
			true,
			function (response) {
				console.log(response);
				$scope.inspectores = response.inspectores;
				$scope.total = response.total;
			});
	};

	$scope.index();

});