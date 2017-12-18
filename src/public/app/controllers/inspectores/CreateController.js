app.controller('Inspectores_CreateController', function($scope, Region) {

    $scope.items = [];
    $scope.cantones = [];
    $scope.distritos = [];

    // Update Canton SELECT
    $scope.updateCantones = function (p) {
        $scope.distritos = [];
        $scope.canton = null;

        Region.cantones(p)
            .then(function (response) { $scope.cantones = Region.parse(response).cantones; });
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function (p, c) {
        Region.distritos(p, c)
            .then(function (response) { $scope.distritos = Region.parse(response).distritos; });
    };

});
