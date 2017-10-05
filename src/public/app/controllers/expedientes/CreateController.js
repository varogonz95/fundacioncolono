app.controller('Expedientes_CreateController', function($scope, Referente, Ayuda, Region, Typeahead) {

    $scope.invalid_add = false;

    $scope.formatter = Typeahead.formatter;
    $scope.ayudas_selected = [{}];

    $scope.cantones = [];
    $scope.distritos = [];

    $scope.estado = $scope.estados[0];

    // Update Canton SELECT
    $scope.updateCantones = function(p){
        $scope.distritos = [];
        $scope.canton = null;

        Region.getCantones(p)
        .then(function(response){ $scope.cantones = Region.toList(response.data);});
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function(p, c){
        Region.getDistritos(p, c)
        .then(function(response){ $scope.distritos = Region.toList(response.data); });
    }

    $scope.ayudaChanged = function(scope, index){
        $scope.invalid_add = false;

        // Revisar en las ayudas seleccionadas
        for (var i = 0; i < $scope.ayudas_selected.length; i++) {

            // Si el elemento de la lista es igual al de la iteracion
            // entonces que lo salte
            if (i === index) { continue; }

            // Sino, si el id del objeto seleccionado
            // es igual al id del elemento de la lista en i
            // entonces el elemento ya se encuentra seleccionado,
            // por lo tanto es invalido
            else if (scope.id === $scope.ayudas_selected[i].id) {
                scope.$invalid = true;
                break;
            }
        }
    };

    $scope.addAyuda = function() {
        if ($scope.ayudas_selected[$scope.ayudas_selected.length - 1].id && !$scope.ayudas_selected[$scope.ayudas_selected.length - 1].$invalid) {
            $scope.invalid_add = false;
            $scope.ayudas_selected.push({});
        }
        else {
            $scope.invalid_add = true;
        }
    };

    $scope.removeAyuda = function(scope){
        $scope.ayudas_selected.splice(getIndex($scope.ayudas_selected, scope),1);
    };

});
