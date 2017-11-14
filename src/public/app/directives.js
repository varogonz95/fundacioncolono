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