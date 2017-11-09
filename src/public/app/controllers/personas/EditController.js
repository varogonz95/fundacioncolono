
/*
*   Controller for entity 'Expediente'
*/
app.controller('Personas_EditController', function ($scope, $http, Persona, Region) {

    $scope.edit = function () {
        var regions = $scope.selected.persona.ubicacion.split('/');
        $scope.selected.persona.editable = true;
        $scope.update.persona = copy($scope.selected.persona, ['editable']);

        Region.getCantones($scope.selected.persona.provincia.cod).then(function (response) {
            $scope.cantones = Region.toList(response.data);
            $scope.selected.persona.canton = Region.find($scope.cantones, 'cod', regions[1]);

            Region.getDistritos($scope.selected.persona.provincia.cod, $scope.selected.persona.canton.cod).then(function (response) {
                $scope.distritos = Region.toList(response.data);
                $scope.selected.persona.distrito = Region.find($scope.distritos, 'cod', regions[2]);
            });
        });
    };

    // Update Canton SELECT
    $scope.updateCantones = function(p){
        $scope.distritos = [];
        $scope.update.persona.canton = null;

        Region.getCantones(p)
        .then(function(response){ $scope.cantones = Region.toList(response.data);});
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function(p, c){
        Region.getDistritos(p, c)
        .then(function(response){ $scope.distritos = Region.toList(response.data); });
    }

    $scope.updatePersona = function () {

        Persona.save(
            {
                cedula: $scope.selected.persona.cedula,
                data: $scope.update.persona,
            },
            function (response) {
                console.log(response);
                if (response.status) {
                    copy($scope.update.persona, $scope.selected.persona);
                    $scope.selected.persona.editable = false;
                }
                else { alert(response.msg); }
            },
            function (error) { alert(error.data.message); }
        );
    };

});
