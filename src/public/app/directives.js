/* app.directive('regionSelectGroup', function (AppResource, Region) {

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
}); */

app.directive('regionText', function (Region) {
	return {
		template: '{{ubicacion}}',
		restrict: 'AE',
		scope:{
			path: '<'
		},
		link: function (scope, element, attrs) {

			scope.$watch("path", function (newVal, oldVal, scp) {

				if (newVal){
					var data = newVal.split('/');

					Region.text(data[0], data[1], data[2])
					.then(function (response) {
						scp.ubicacion = Region.parse(response).location.text;
					})
				}
			});

		},
	};
});