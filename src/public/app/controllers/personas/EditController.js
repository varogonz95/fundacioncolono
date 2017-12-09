
/*
*   Controller for entity 'Expediente'
*/
app.controller('Personas_EditController', function ($scope, $http, Persona, Region) {

    $scope.edit = function () {
        var regions = $scope.selected.persona.ubicacion.split('/');
        $scope.selected.persona.editable = true;
        $scope.update.persona = copy($scope.selected.persona, ['editable']);

        Region.cantones($scope.selected.persona.provincia.cod).then(function (response) {
            console.log(response);          
            $scope.cantones = Region.parse(response).cantones;
            $scope.selected.persona.canton = Region.find($scope.cantones, 'cod', regions[1]);

            Region.distritos($scope.selected.persona.provincia.cod, $scope.selected.persona.canton.cod).then(function (response) {
                console.log(response);
                $scope.distritos = Region.parse(response).distritos;
                $scope.selected.persona.distrito = Region.find($scope.distritos, 'cod', regions[2]);
            });
        });
    };

    // Update Canton SELECT
    $scope.updateCantones = function(p){
        $scope.distritos = [];
        $scope.update.persona.canton = null;

        Region.cantones(p)
        .then(function(response){ $scope.cantones = Region.parse(response).cantones;});
    };

    // Update Distrito SELECT
    $scope.updateDistritos = function(p, c){
        Region.distritos(p, c)
        .then(function(response){ $scope.distritos = Region.parse(response).distritos; });
    }

    $scope.updatePersona = function () {

        Persona.save(
            {
                cedula: $scope.selected.persona.cedula,
                data: $scope.update.persona,
            },
            function (response) {
                if (response.status) {
                    console.log('selected.persona');
                    console.log($scope.selected.persona);
                    console.log('will become');
                    console.log($scope.update.persona);
                    console.log('final data');
                    console.log(copy($scope.update.persona, $scope.selected.persona));
                    
                    // $scope.selected.persona.ubicacion = $scope.selected.persona.canton.

                    console.log($scope.selected.persona);
                    console.log($scope.update.persona);

                    $scope.selected.persona.editable = false;
                }
                else { alert(response.msg); }
            },
            function (error) { alert(error.data.message); }
        );
    };

});
