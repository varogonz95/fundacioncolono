app.directive('regionSelectGroup', function (AppResource, Region) {

	var scope = {
			// Provincias data binding
			provinciaModel:   '=',
			provinciaOptions: '=',
			// Canton data binding
			cantonModel:      '=',
			cantonOptions:    '=',
			// Distrito data binding
			distritoModel:    '=',
			distritoOptions:  '=',
		},
		link = function(scope, element, attrs){
			scope.updateCantones = function(){
				console.log('update cantones');
			};

			scope.updateDistritos = function(){
				console.log('update distritos');
			};
		};

	return {
		link:        link,
		scope:       {},
		restrict:    'AE',
		templateUrl:  AppResource.getUrl() + '/app/templates/test.html',
	};
});

app.directive('regionText', function (Region) {
	return {
		template: '{{ubicacion}}',
		restrict: 'AE',
		link: function (scope, element, attrs) {
			
			scope.$watch(attrs.path, function(value){
				
				if (value && value.trim() !== '') {
					var data = value.split('/'),
						provincia = Region.find(Region.getProvincias(), 'cod', data[0]),
						canton, distrito;
		
					Region.getCantones(provincia.cod)
						.then(function (response) {
							canton = Region.find(Region.toList(response.data), 'cod', data[1]);
		
							Region.getDistritos(provincia.cod, canton.cod)
								.then(function (response) {
									distrito = Region.find(Region.toList(response.data), 'cod', data[2]);
		
									scope.ubicacion = provincia.name + ', ' + canton.name + ', ' + distrito.name;
									scope.ngModel = scope.ubicacion;
								});
						});
				}
			});


		},
	};
});